<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Teacher\CategoryController;
use App\Http\Controllers\Teacher\GroupController;
use App\Http\Controllers\Teacher\StatisticsController;
use App\Http\Controllers\Teacher\StudentController;
use App\Http\Controllers\Teacher\TaskController;
use App\Http\Controllers\Teacher\TestController;
use App\Http\Middleware\TeacherAuthenticate;
use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('index');

Route::get('/dashboard', function () {
    return redirect()->intended(route('index', absolute: false));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// рауты кабинета учителя
//Route::middleware('auth')->group(function () {
Route::middleware([TeacherAuthenticate::class])->group(function () {
    Route::get('/groups', [GroupController::class, 'index'])->name('groups');
    Route::get('/group/{id}', [GroupController::class, 'showGroup'])->name('show.group');
    Route::post('/group', [GroupController::class, 'store'])->name('store.group');
    Route::patch('/group', [GroupController::class, 'patch'])->name('patch.group');
    Route::delete('/group', [GroupController::class, 'delete'])->name('delete.group');
    Route::get('/group/export-to-pdf/{group_id}', [GroupController::class, 'exportStudentsToPdf'])->name('export.to.pdf.group');
    Route::get('/group-results/{group_id}', [GroupController::class, 'showGroupResults'])->name('show.group.results');
    Route::get('/group-tasks/{group_id}', [GroupController::class, 'showGroupTasks'])->name('show.group.tasks');

    Route::post('/transliterate', [GroupController::class, 'transliterate'])->name('transliterate');

    Route::get('/students', [StudentController::class, 'index'])->name('students');
    Route::get('/student/{id}', [StudentController::class, 'showStudent'])->name('show.student');
    Route::post('/student', [StudentController::class, 'store'])->name('store.student');
    Route::patch('/student', [StudentController::class, 'update'])->name('update.student');
    Route::delete('/student', [StudentController::class, 'destroy'])->name('delete.student');

    Route::get('/categories', [CategoryController::class, 'index'])->name('categories');
    Route::get('/category/{id}', [CategoryController::class, 'showCategory'])->name('show.category');
    Route::post('/category', [CategoryController::class, 'store'])->name('store.category');
    Route::delete('/category', [CategoryController::class, 'destroy'])->name('delete.category');

    Route::get('/tests', [TestController::class, 'index'])->name('tests');
    Route::get('/test', [TestController::class, 'showAddTestPage'])->name('add.test');
    Route::get('/test/{id}', [TestController::class, 'showTest'])->name('show.test');
    Route::get('/update-test/{id}', [TestController::class, 'showUpdateTestPage'])->name('show.update.test.page');
    Route::delete('/test/{id}', [TestController::class, 'destroy'])->name('delete.test');
    Route::post('/test/question/{id}', [TestController::class, 'destroyQuestion'])->name('delete.question.test');
    Route::post('/test/save-test-name', [TestController::class, 'saveTestName'])->name('save.test.name');
    Route::post('/test/save-test-question', [TestController::class, 'saveTestQuestion']);
    Route::post('/test/save-text-answer', [TestController::class, 'saveTextAnswer']);
    Route::post('/test/save-multiple-answer', [TestController::class, 'saveMultipleAnswer']);
    Route::post('/test/update-text', [TestController::class, 'updateText']);
    Route::post('/test/update-right-answers', [TestController::class, 'updateRightAnswer']);

    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks');
    Route::get('/task/{id}', [TaskController::class, 'showTask'])->name('show.task.results');
    Route::get('/add-task', [TaskController::class, 'addTask'])->name('add.task');
    Route::post('/task', [TaskController::class, 'store'])->name('store.task');
    Route::delete('/task', [TaskController::class, 'destroy'])->name('delete.task');
    Route::post('/get-tests-by-category', [TaskController::class, 'getTestsByCategory'])->name('get.tests.by.category');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/statistics', [StatisticsController::class, 'index'])->name('statistics');
    Route::get('/statistics/task/{task_id}', [StatisticsController::class, 'showGroupResult'])->name('show.group.result');
    Route::get('/statistics/student-result', [StatisticsController::class, 'showStudentResult'])->name('show.student.result.stat');
});

// рауты кабинета ученика
Route::middleware('auth')->group(function () {
    Route::get('/student-dashboard', [\App\Http\Controllers\Student\DashboardController::class, 'index'])->name('student.dashboard');
    Route::get('/pass-test', [\App\Http\Controllers\Student\TestController::class, 'index'])->name('student.pass.test.index');
    Route::post('/store-student-answer', [\App\Http\Controllers\Student\TestController::class, 'storeStudentAnswer'])->name('store.student.answer');
    Route::post('/mark-test-passing', [\App\Http\Controllers\Student\TestController::class, 'markTestPassing'])->name('mark.test.passing');

    Route::get('/student-statistics', [\App\Http\Controllers\Student\StatisticsController::class, 'index'])->name('student.statistics');
    Route::get('/student-statistics/result', [\App\Http\Controllers\Student\StatisticsController::class, 'showStudentResult'])->name('student.statistics.test.result');
});

require __DIR__.'/auth.php';
