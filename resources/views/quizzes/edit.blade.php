<!DOCTYPE html>
<html>
<head>
    <title>Edit Quiz</title>
</head>
<body>
<h2>Edit Quiz</h2>
<form method="POST" action="{{ route('quizzes.update', $quiz) }}">
    @csrf
    @method('PUT')
    <div>
        <label for="title">Title</label>
        <input type="text" name="title" id="title" value="{{ $quiz->title }}" required>
        @error('title')
        <span style="color: red;">{{ $message }}</span>
        @enderror
    </div>
    <div>
        <label for="description">Description</label>
        <textarea name="description" id="description" required>{{ $quiz->description }}</textarea>
        @error('description')
        <span style="color: red;">{{ $message }}</span>
        @enderror
    </div>
    <div>
        <label for="category_id">Category</label>
        <select name="category_id" id="category_id" required>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" {{ $category->id == $quiz->category_id ? 'selected' : '' }}>{{ $category->title }}</option>
            @endforeach
        </select>
        @error('category_id')
        <span style="color: red;">{{ $message }}</span>
        @enderror
    </div>
    <div id="questions">
        @foreach ($quiz->questions as $qIndex => $question)
            <h3>Question {{ $qIndex + 1 }}</h3>
            <input type="hidden" name="questions[{{ $qIndex }}][id]" value="{{ $question->id }}">
            <div>
                <label>Question</label>
                <input type="text" name="questions[{{ $qIndex }}][question]" value="{{ $question->question }}" required>
                @error("questions.{$qIndex}.question")
                <span style="color: red;">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label>Type</label>
                <select name="questions[{{ $qIndex }}][type]" required>
                    <option value="single" {{ $question->type == 'single' ? 'selected' : '' }}>Single Choice</option>
                    <option value="multiple" {{ $question->type == 'multiple' ? 'selected' : '' }}>Multiple Choice</option>
                </select>
                @error("questions.{$qIndex}.type")
                <span style="color: red;">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label>Answers</label>
                @foreach ($question->answers as $aIndex => $answer)
                    <div>
                        <input type="hidden" name="questions[{{ $qIndex }}][answers][{{ $aIndex }}][id]" value="{{ $answer->id }}">
                        <input type="text" name="questions[{{ $qIndex }}][answers][{{ $aIndex }}][answer]" value="{{ $answer->answer }}" required>
                        <label><input type="checkbox" name="questions[{{ $qIndex }}][answers][{{ $aIndex }}][is_correct]" value="1" {{ $answer->is_correct ? 'checked' : '' }}> Correct</label>
                        @error("questions.{$qIndex}.answers.{$aIndex}.answer")
                        <span style="color: red;">{{ $message }}</span>
                        @enderror
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
    <button type="submit">Update</button>
</form>
<a href="{{ route('quizzes.index') }}">Back</a>
</body>
</html>
