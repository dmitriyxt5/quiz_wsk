<!DOCTYPE html>
<html>
<head>
    <title>Deleted Quizzes</title>
</head>
<body>
<h2>Deleted Quizzes</h2>
<ul>
    @foreach ($quizzes as $quiz)
        <li>{{ $quiz->title }} (Category: {{ $quiz->category->title }}) - Deleted at {{ $quiz->deleted_at }}</li>
    @endforeach
</ul>
<a href="{{ route('admin') }}">Back to Admin</a>
</body>
</html>
