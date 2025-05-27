<!DOCTYPE html>
<html>
<head>
    <title>Statistics for {{ $quiz->title }}</title>
</head>
<body>
<h2>Statistics for {{ $quiz->title }}</h2>
@foreach ($statistics as $stat)
    <div>
        <h3>{{ $stat['question'] }}</h3>
        <ul>
            @foreach ($stat['answers'] as $answer)
                <li>{{ $answer['answer'] }} - {{ $answer['count'] }} responses</li>
            @endforeach
        </ul>
    </div>
@endforeach
<a href="{{ route('quizzes.index') }}">Back to Quizzes</a>
</body>
</html>
