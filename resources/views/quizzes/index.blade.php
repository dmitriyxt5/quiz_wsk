<!DOCTYPE html>
<html>
<head>
    <title>Quizzes</title>
</head>
<body>
<h2>Quizzes</h2>
@if (session('success'))
    <p style="color: green;">{{ session('success') }}</p>
@endif
<p>Debug: {{ count($quizzes) }} quizzes found</p>
<a href="{{ route('quizzes.create') }}">Create Quiz</a>
<ul>
    @forelse ($quizzes as $quiz)
        <li>
            {{ $quiz->title }} (Category: {{ $quiz->category ? $quiz->category->title : 'No Category' }})
            <a href="{{ route('quizzes.edit', $quiz) }}">Edit</a>
            <a href="{{ route('quizzes.short-links.index', $quiz) }}">Short Links</a>
            <a href="{{ route('quizzes.responses', $quiz) }}">Responses</a>
            <a href="{{ route('quizzes.statistics', $quiz) }}">Statistics</a>
            <form method="POST" action="{{ route('quizzes.destroy', $quiz) }}" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('Are you sure?')">Delete</button>
            </form>
        </li>
    @empty
        <li>No quizzes found.</li>
    @endforelse
</ul>
<a href="{{ route('admin') }}">Back to Admin</a>
</body>
</html>
