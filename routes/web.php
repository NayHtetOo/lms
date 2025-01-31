<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\userController;
use App\Livewire\AssignmentView;
use App\Livewire\Counter;
use App\Livewire\Course;
use App\Livewire\CourseDetail;
use App\Livewire\CourseView;
use App\Livewire\ExamView;
use App\Livewire\Home;
use App\Livewire\LessonView;
use App\Models\Course as ModelsCourse;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [userController::class, 'index'])->name('welcome');
Route::post('/submit', [userController::class, 'submit']);
// Route::get('/admin/login', function () {
//     return view('auth.login'); // Replace with your custom login view
// })->name('filament.auth.login');



Route::get('/counter', Counter::class)->name('counter');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::get('/home', Home::class)->name('home');
    Route::get('/courses', Course::class)->name('courses');
    Route::get('/course_view/{id}', CourseView::class)->name('course_view');
    Route::get('/lesson_view/{course_id}/{section_id}/{id}', LessonView::class)->name('lesson_view');
    Route::get('/exam_view/{course_id}/{section_id}/{id}', ExamView::class)->name('exam_view')->middleware('web');
    Route::get('/assignment_view/{course_id}/{section_id}/{id}', AssignmentView::class)->name('assignment_view');
    Route::get('/course_detail/{course_id}', CourseDetail::class)->name('course_detail');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
