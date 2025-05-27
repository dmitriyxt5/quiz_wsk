<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\Answer;
use App\Models\ResponseAnswer;
use App\Models\ShortLink;
use App\Models\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class QuizController extends Controller
{
    public function index()
    {
        return view('quizzes.index', ['quizzes' => Quiz::with('category')->whereNull('deleted_at')->get()]);
    }

    public function store(Request $request)
    {
        Log::info('Quiz creation request', $request->all());

        try {
            $request->validate([
                'title' => 'required|string|min:3|max:255',
                'description' => 'required|string',
                'category_id' => 'required|exists:categories,id',
                'questions' => 'required|array|min:1',
                'questions.*.question' => 'required|string|min:3|max:255',
                'questions.*.type' => 'required|in:single,multiple',
                'questions.*.answers' => 'required|array|size:4',
                'questions.*.answers.*.answer' => 'required|string|max:128',
                'questions.*.answers.*.is_correct' => 'required|boolean',
            ]);
        } catch (ValidationException $e) {
            Log::error('Validation failed', ['errors' => $e->errors(), 'request' => $request->all()]);
            throw $e;
        }

        DB::beginTransaction();
        try {
            $quiz = Quiz::create($request->only('title', 'description', 'category_id'));
            Log::info('Quiz created', ['quiz_id' => $quiz->id, 'title' => $quiz->title]);

            foreach ($request->questions as $questionData) {
                $question = Question::create([
                    'quiz_id' => $quiz->id,
                    'question' => $questionData['question'],
                    'type' => $questionData['type'],
                ]);

                foreach ($questionData['answers'] as $answerData) {
                    Answer::create([
                        'question_id' => $question->id,
                        'answer' => $answerData['answer'],
                        'is_correct' => $answerData['is_correct'],
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('quizzes.index')->with('success', 'Quiz created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Quiz creation failed: ' . $e->getMessage(), ['request' => $request->all()]);
            return redirect()->back()->withErrors(['error' => 'Failed to create quiz: ' . $e->getMessage()]);
        }
    }

    public function create()
    {
        return view('quizzes.create', ['categories' => Category::all()]);
    }

    public function edit(Quiz $quiz)
    {
        return view('quizzes.edit', ['quiz' => $quiz->load('questions.answers'), 'categories' => Category::all()]);
    }

    public function update(Request $request, Quiz $quiz)
    {
        $request->validate([
            'title' => 'required|string|min:3|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'questions' => 'required|array|size:'.count($quiz->questions),
            'questions.*.id' => 'required|exists:questions,id',
            'questions.*.question' => 'required|string|min:3|max:255',
            'questions.*.type' => 'required|in:single,multiple',
            'questions.*.answers' => 'required|array|size:4',
            'questions.*.answers.*.id' => 'required|exists:answers,id',
            'questions.*.answers.*.answer' => 'required|string|max:128',
            'questions.*.answers.*.is_correct' => 'required|boolean',
        ]);

        $quiz->update($request->only('title', 'description', 'category_id'));

        foreach ($request->questions as $questionData) {
            $question = Question::find($questionData['id']);
            $question->update([
                'question' => $questionData['question'],
                'type' => $questionData['type'],
            ]);

            foreach ($questionData['answers'] as $answerData) {
                $answer = Answer::find($answerData['id']);
                $answer->update([
                    'answer' => $answerData['answer'],
                    'is_correct' => $answerData['is_correct'],
                ]);
            }
        }

        return redirect()->route('quizzes.index')->with('success', 'Quiz updated successfully.');
    }

    public function destroy(Quiz $quiz)
    {
        $quiz->delete();
        return redirect()->route('quizzes.index')->with('success', 'Quiz deleted successfully.');
    }

    public function deleted()
    {
        return view('quizzes.deleted', ['quizzes' => Quiz::onlyTrashed()->with('category')->get()]);
    }

    public function show($code)
    {
        $shortLink = ShortLink::where('code', $code)->firstOrFail();
        $quiz = $shortLink->quiz()->with(['category', 'questions.answers'])->firstOrFail();
        return view('quizzes.show', ['quiz' => $quiz, 'shortLink' => $shortLink]);
    }

    public function submit(Request $request, $code)
    {
        $shortLink = ShortLink::where('code', $code)->firstOrFail();
        $quiz = $shortLink->quiz()->with('questions')->firstOrFail();

        $request->validate([
            'answers' => 'required|array|size:'.count($quiz->questions),
            'answers.*' => 'required|array|min:1',
            'answers.*.*' => 'exists:answers,id',
        ]);

        foreach ($quiz->questions as $index => $question) {
            $selectedAnswerIds = $request->answers[$index];
            if ($question->type === 'single' && count($selectedAnswerIds) > 1) {
                return back()->withErrors(['answers.'.$index => 'Single-choice question allows only one answer.']);
            }
            foreach ($selectedAnswerIds as $answerId) {
                if (!Answer::where('id', $answerId)->where('question_id', $question->id)->exists()) {
                    return back()->withErrors(['answers.'.$index => 'Invalid answer selected.']);
                }
            }
        }

        $response = Response::create([
            'quiz_id' => $quiz->id,
            'short_link_id' => $shortLink->id,
            'user_agent' => $request->userAgent(),
            'ip_address' => $request->ip(),
            'submitted_at' => now(),
        ]);

        foreach ($quiz->questions as $index => $question) {
            foreach ($request->answers[$index] as $answerId) {
                ResponseAnswer::create([
                    'response_id' => $response->id,
                    'question_id' => $question->id,
                    'answer_id' => $answerId,
                ]);
            }
        }

        return redirect()->route('quiz.show', $code)->with('success', 'Thank you for completing the quiz.');
    }
}
