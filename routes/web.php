<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\GuideController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\TutorController;
use Illuminate\Support\Facades\Route;

Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');
Route::get('/llms.txt', [PageController::class, 'llms'])->name('llms');

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
Route::get('/courses/{course:slug}', [CourseController::class, 'show'])->name('courses.show');

// Public lesson view. Access is enforced inside the controller:
//   - preview lessons -> everyone (guests included), for a public first look
//   - all other lessons -> redirect guests to sign up / members to upgrade
Route::get('/courses/{course:slug}/lessons/{lesson}', [LessonController::class, 'show'])->name('lessons.show');

// Static / informational pages (SEO + AEO + trust)
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::get('/faq', [PageController::class, 'faq'])->name('faq');
Route::get('/guides', [GuideController::class, 'index'])->name('guides.index');
Route::get('/guides/{slug}', [GuideController::class, 'show'])->name('guides.show');

// Lead magnet (free download for an email)
Route::get('/free-guide', [LeadController::class, 'show'])->name('lead.show');
Route::post('/free-guide', [LeadController::class, 'store'])->name('lead.store');
Route::get('/free-guide/thank-you', [LeadController::class, 'thanks'])->name('lead.thanks');
Route::get('/terms', [PageController::class, 'terms'])->name('terms');
Route::get('/privacy', [PageController::class, 'privacy'])->name('privacy');
Route::get('/refund-policy', [PageController::class, 'refund'])->name('refund');

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

    /*
    | Per-course tier access is enforced inside the controllers (server-side):
    |   - free course  -> any signed-in user
    |   - pro / elite  -> active member of that tier (or admin)
    |   - preview lessons -> any signed-in user, regardless of plan
    | Hiding buttons is not enough; the controllers return 403 / redirect for locked content.
    */
    Route::post('/courses/{course:slug}/enroll', [CourseController::class, 'enroll'])->name('courses.enroll');
    Route::post('/courses/{course:slug}/lessons/{lesson}/complete', [LessonController::class, 'complete'])->name('lessons.complete');
    Route::post('/courses/{course:slug}/lessons/{lesson}/tutor', [TutorController::class, 'chat'])->name('tutor.chat');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
