<?php

namespace App\Http\Controllers;

use App\Models\Quiz;

class ResponseController extends Controller
{
    public function index(Quiz $quiz)
    {
        return view('responses.index', ['quiz' => $quiz->load(['responses.responseAnswers.answer', 'responses.shortLink'])]);
    }

    public function statistics(Quiz $quiz)
    {
        $statistics = [];
        $questions = $quiz->questions()->with('answers')->get();

        foreach ($questions as $question) {
            $stats = [];
            foreach ($question->answers as $answer) {
                $count = \App\Models\ResponseAnswer::where('question_id', $question->id)
                    ->where('answer_id', $answer->id)
                    ->count();
                $stats[] = ['answer' => $answer->answer, 'count' => $count];
            }
            $statistics[] = ['question' => $question->question, 'answers' => $stats];
        }

        return view('responses.statistics', ['quiz' => $quiz, 'statistics' => $statistics]);
    }
}
