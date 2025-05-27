<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\ShortLinkController;
use App\Http\Controllers\ResponseController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [AdminController::class, 'login'])->name('login');
Route::post('/login', [AdminController::class, 'authenticate'])->name('authenticate');
Route::get('/logout', [AdminController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin');

    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    Route::get('/quizzes', [QuizController::class, 'index'])->name('quizzes.index');
    Route::get('/quizzes/create', [QuizController::class, 'create'])->name('quizzes.create');
    Route::post('/quizzes', [QuizController::class, 'store'])->name('quizzes.store');
    Route::get('/quizzes/{quiz}/edit', [QuizController::class, 'edit'])->name('quizzes.edit');
    Route::put('/quizzes/{quiz}', [QuizController::class, 'update'])->name('quizzes.update');
    Route::delete('/quizzes/{quiz}', [QuizController::class, 'destroy'])->name('quizzes.destroy');
    Route::get('/quizzes/deleted', [QuizController::class, 'deleted'])->name('quizzes.deleted');

    Route::get('/quizzes/{quiz}/short-links', [ShortLinkController::class, 'index'])->name('quizzes.short-links.index');
    Route::post('/quizzes/{quiz}/short-links', [ShortLinkController::class, 'store'])->name('quizzes.short-links.store');
    Route::delete('/quizzes/{quiz}/short-links/{shortLink}', [ShortLinkController::class, 'destroy'])->name('quizzes.short-links.destroy');

    Route::get('/quizzes/{quiz}/responses', [ResponseController::class, 'index'])->name('quizzes.responses');
    Route::get('/quizzes/{quiz}/statistics', [ResponseController::class, 'statistics'])->name('quizzes.statistics');
});

Route::get('/q/{code}', [QuizController::class, 'show'])->name('quiz.show');
Route::post('/q/{code}', [QuizController::class, 'submit'])->name('quiz.submit');
