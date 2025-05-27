<!DOCTYPE html>
<html>
<head>
    <title>Responses for {{ $quiz->title }}</title>
</head>
<body>
<h2>Responses for {{ $quiz->title }}</h2>
@foreach ($quiz->responses as $response)
    <div>
        <p><strong>User-Agent:</strong> {{ $response->user_agent }}</p>
        <p><strong>Short Link:</strong> {{ $response->shortLink ? 'http://localhost:8000/q/'.$response->shortLink->code : 'Deleted' }}</p>
        <p><strong>IP Address:</strong> {{ $response->ip_address }}</p>
        <p><strong>Submitted At:</strong> {{ $response->submitted_at }}</p>
        <p><strong>Answers:</strong></p>
        <ul>
            @foreach ($response->responseAnswers as $responseAnswer)
                <li>{{ $responseAnswer->question->question }}: {{ $responseAnswer->answer->answer }}</li>
            @endforeach
        </ul>
        <hr>
    </div>
@endforeach
<a href="{{ route('quizzes.index') }}">Back to Quizzes</a>
</body>
</html>
