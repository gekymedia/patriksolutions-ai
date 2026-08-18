<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TutorController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
Route::get('/courses/{course:slug}', [CourseController::class, 'show'])->name('courses.show');

Route::get('/membership', [MembershipController::class, 'index'])->name('membership.index');

Route::middleware('auth')->group(function () {
    Route::post('/membership/subscribe', [MembershipController::class, 'subscribe'])->name('membership.subscribe');
    Route::post('/membership/cancel', [MembershipController::class, 'cancel'])->name('membership.cancel');
    Route::post('/membership/resume', [MembershipController::class, 'resume'])->name('membership.resume');
    Route::get('/membership/billing', [MembershipController::class, 'billingPortal'])->name('membership.billing');
});

Route::post('/stripe/webhook', '\Laravel\Cashier\Http\Controllers\WebhookController@handleWebhook')
    ->name('cashier.webhook');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [CourseController::class, 'dashboard'])->name('dashboard');

    Route::post('/courses/{course:slug}/enroll', [CourseController::class, 'enroll'])
        ->middleware('member')
        ->name('courses.enroll');

    Route::middleware('member')->group(function () {
        Route::get('/courses/{course:slug}/lessons/{lesson}', [LessonController::class, 'show'])->name('lessons.show');
        Route::post('/courses/{course:slug}/lessons/{lesson}/complete', [LessonController::class, 'complete'])->name('lessons.complete');
        Route::post('/courses/{course:slug}/lessons/{lesson}/tutor', [TutorController::class, 'chat'])->name('tutor.chat');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
