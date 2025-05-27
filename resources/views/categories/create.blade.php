<!DOCTYPE html>
<html>
<head>
    <title>Create Category</title>
</head>
<body>
<h2>Create Category</h2>
<form method="POST" action="{{ route('categories.store') }}">
    @csrf
    <div>
        <label for="title">Title</label>
        <input type="text" name="title" id="title" required>
        @error('title')
        <span style="color: red;">{{ $message }}</span>
        @enderror
    </div>
    <button type="submit">Save</button>
</form>
<a href="{{ route('categories.index') }}">Back</a>
</body>
</html>
