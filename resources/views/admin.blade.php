<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
</head>
<body>
<h2>Welcome, {{ $user->name }}!</h2>
@if (session('success'))
    <p style="color: green;">{{ session('success') }}</p>
@endif
<div class="flex flex-col gap-2 p-3 bg-blue-500">
    <p><a href="{{ route('categories.index') }}">Manage Categories</a></p>
    <p><a href="{{ route('quizzes.index') }}">Manage Quizzes</a></p>
    <p><a href="{{ route('quizzes.deleted') }}">View Deleted Quizzes</a></p>
</div>
<form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit">Logout</button>
</form>
</body>
</html>
