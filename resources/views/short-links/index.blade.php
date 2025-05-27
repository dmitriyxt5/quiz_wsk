<!DOCTYPE html>
<html>
<head>
    <title>Short Links for {{ $quiz->title }}</title>
</head>
<body>
<h2>Short Links for {{ $quiz->title }}</h2>
@if (session('success'))
    <p style="color: green;">{{ session('success') }}</p>
@endif
<form method="POST" action="{{ route('quizzes.short-links.store', $quiz) }}">
    @csrf
    <button type="submit">Create Short Link</button>
</form>
<ul>
    @foreach ($quiz->shortLinks as $shortLink)
        <li>
            http://localhost:8000/q/{{ $shortLink->code }}
            <form method="POST" action="{{ route('quizzes.short-links.destroy', [$quiz, $shortLink]) }}" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('Are you sure?')">Delete</button>
            </form>
        </li>
    @endforeach
</ul>
<a href="{{ route('quizzes.index') }}">Back to Quizzes</a>
</body>
</html>
