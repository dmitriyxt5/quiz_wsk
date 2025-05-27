<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
<h2>Login</h2>
<form method="POST" action="{{ route('login') }}">
    @csrf
    <div>
        <label for="email">Email</label>
        <input type="email" name="email" id="email" required>
        @error('email')
        <span style="color: red;">{{ $message }}</span>
        @enderror
    </div>
    <div>
        <label for="password">Password</label>
        <input type="password" name="password" id="password" required>
    </div>
    <button type="submit">Login</button>
</form>
</body>
</html>
