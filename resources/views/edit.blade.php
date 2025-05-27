<!DOCTYPE html>
<html>
<head>
    <title>Edit Category</title>
</head>
<body>
<h2>Edit Category</h2>
<form method="POST" action="{{ route('categories.update', $category) }}">
    @csrf
    @method('PUT')
    <div>
        <label for="title">Title</label>
        <input type="text" name="title" id="title" value="{{ $category->title }}" required>
        @error('title')
        <span style="color: red;">{{ $message }}</span>
        @enderror
    </div>
    <button type="submit">Update</button>
</form>
<a href="{{ route('categories.index') }}">Back</a>
</body>
</html>
