<!DOCTYPE html>
<html>
<head>
    <title>Categories</title>
</head>
<body>
<h2>Categories</h2>
@if (session('success'))
    <p style="color: green;">{{ session('success') }}</p>
@endif
<a href="{{ route('categories.create') }}">Create Category</a>
<ul>
    @foreach ($categories as $category)
        <li>
            {{ $category->title }}
            <a href="{{ route('categories.edit', $category) }}">Edit</a>
        </li>
    @endforeach
</ul>
<a href="{{ route('admin') }}">Back to Admin</a>
</body>
</html>
