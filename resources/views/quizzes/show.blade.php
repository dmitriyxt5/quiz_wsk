<!DOCTYPE html>
<html>
<head>
    <title>{{ $quiz->title }}</title>
</head>
<body>
<h2>{{ $quiz->title }}</h2>
@if (session('success'))
    <p style="color: green;">{{ session('success') }}</p>
@endif
<p><strong>Category:</strong> {{ $quiz->category->title }}</p>
<p><strong>Description:</strong> {{ $quiz->description }}</p>
<form method="POST" action="{{ route('quiz.submit', $shortLink->code) }}">
    @csrf
    @foreach ($quiz->questions as $qIndex => $question)
        <div>
            <h3>{{ $question->question }}</h3>
            @foreach ($question->answers as $answer)
                <div>
                    <label>
                        <input type="{{ $question->type === 'single' ? 'radio' : 'checkbox' }}"
                               name="answers[{{ $qIndex }}][]"
                               value="{{ $answer->id }}"
                               required>
                        {{ $answer->answer }}
                    </label>
                </div>
            @endforeach
            @error("answers.{$qIndex}")
            <span style="color: red;">{{ $message }}</span>
            @enderror
        </div>
    @endforeach
    <button type="submit">Complete Quiz</button>
</form>
</body>
</html>
