<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\ShortLink;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ShortLinkController extends Controller
{
    public function index(Quiz $quiz)
    {
        return view('short-links.index', ['quiz' => $quiz->load('shortLinks')]);
    }

    public function store(Request $request, Quiz $quiz)
    {
        $code = Str::random(8);
        while (ShortLink::where('code', $code)->exists()) {
            $code = Str::random(8);
        }

        ShortLink::create([
            'quiz_id' => $quiz->id,
            'code' => $code,
        ]);

        return redirect()->route('quizzes.short-links.index', $quiz)
            ->with('success', 'Short link created: http://localhost:8000/q/'.$code);
    }

    public function destroy(Quiz $quiz, ShortLink $shortLink)
    {
        $shortLink->delete();
        return redirect()->route('quizzes.short-links.index', $quiz)
            ->with('success', 'Short link deleted successfully.');
    }
}
