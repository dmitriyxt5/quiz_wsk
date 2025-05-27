<!DOCTYPE html>
<html>
<head>
    <title>Create Quiz</title>
</head>
<body>
<h2>Create Quiz</h2>
@if ($errors->any())
    <div style="color: red;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form method="POST" action="{{ route('quizzes.store') }}">
    @csrf
    <div>
        <label for="title">Title</label>
        <input type="text" name="title" id="title" value="{{ old('title') }}" required>
    </div>
    <div>
        <label for="description">Description</label>
        <textarea name="description" id="description" required>{{ old('description') }}</textarea>
    </div>
    <div>
        <label for="category_id">Category</label>
        <select name="category_id" id="category_id" required>
            @if ($categories->isEmpty())
                <option value="">No categories available</option>
            @else
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->title }}</option>
                @endforeach
            @endif
        </select>
    </div>
    <div id="questions">
        <h3>Question 1</h3>
        <div>
            <label>Question</label>
            <input type="text" name="questions[0][question]" value="{{ old('questions.0.question') }}" required>
        </div>
        <div>
            <label>Type</label>
            <select name="questions[0][type]" required>
                <option value="single" {{ old('questions.0.type') == 'single' ? 'selected' : '' }}>Single Choice</option>
                <option value="multiple" {{ old('questions.0.type') == 'multiple' ? 'selected' : '' }}>Multiple Choice</option>
            </select>
        </div>
        <div>
            <label>Answers</label>
            @for ($i = 0; $i < 4; $i++)
                <div>
                    <input type="text" name="questions[0][answers][{{ $i }}][answer]" value="{{ old('questions.0.answers.' . $i . '.answer') }}" required>
                    <input type="hidden" name="questions[0][answers][{{ $i }}][is_correct]" value="0">
                    <label><input type="checkbox" name="questions[0][answers][{{ $i }}][is_correct]" value="1" {{ old('questions.0.answers.' . $i . '.is_correct') ? 'checked' : '' }}> Correct</label>
                </div>
            @endfor
        </div>
    </div>
    <button type="button" onclick="addQuestion()">Add Question</button>
    <button type="submit">Save</button>
</form>
<a href="{{ route('quizzes.index') }}">Back</a>
<script>
    let questionCount = 1;
    function addQuestion() {
        const questionsDiv = document.getElementById('questions');
        const questionHtml = `
                <h3>Question ${questionCount + 1}</h3>
                <div>
                    <label>Question</label>
                    <input type="text" name="questions[${questionCount}][question]" required>
                </div>
                <div>
                    <label>Type</label>
                    <select name="questions[${questionCount}][type]" required>
                        <option value="single">Single Choice</option>
                        <option value="multiple">Multiple Choice</option>
                    </select>
                </div>
                <div>
                    <label>Answers</label>
                    ${Array.from({length: 4}, (_, i) => `
                        <div>
                            <input type="text" name="questions[${questionCount}][answers][${i}][answer]" required>
                            <input type="hidden" name="questions[${questionCount}][answers][${i}][is_correct]" value="0">
                            <label><input type="checkbox" name="questions[${questionCount}][answers][${i}][is_correct]" value="1"> Correct</label>
                        </div>
                    `).join('')}
                </div>
            `;
        questionsDiv.insertAdjacentHTML('beforeend', questionHtml);
        questionCount++;
    }
</script>
</body>
</html>
