<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\OtpController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KnowledgeController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SectionController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::get('/about', [AboutController::class, 'show'])->name('about');
Route::get('/contact', [ContactController::class, 'show'])->name('contact');
Route::get('/faq', [FaqController::class, 'index'])->name('faq.index');

Route::prefix('knowledge')->name('knowledge.')->group(function () {
    Route::get('/', [KnowledgeController::class, 'index'])->name('index');
    Route::get('/{category:slug}', [KnowledgeController::class, 'category'])->name('category');
    Route::get('/{category:slug}/{article:slug}', [KnowledgeController::class, 'article'])->name('article');
});

Route::get('/search', [SearchController::class, 'index'])->name('search.index');
Route::get('/search/suggest', [SearchController::class, 'suggest'])->name('search.suggest');

Route::prefix('sections')->name('section.')->group(function () {
    Route::get('/marketplace', [SectionController::class, 'marketplace'])->name('marketplace');
    Route::get('/find-a-vet', [SectionController::class, 'findVet'])->name('find-vet');
    Route::get('/training', [SectionController::class, 'training'])->name('training');
    Route::get('/community', [SectionController::class, 'community'])->name('community');
    Route::get('/market-prices', [SectionController::class, 'marketPrices'])->name('market-prices');
});
Route::get('/marketplace', fn () => redirect()->route('section.marketplace'))->name('marketplace');
Route::get('/find-a-vet', fn () => redirect()->route('section.find-vet'))->name('find-vet');
Route::get('/training', fn () => redirect()->route('section.training'))->name('training');
Route::get('/community', fn () => redirect()->route('section.community'))->name('community');
Route::get('/market-prices', fn () => redirect()->route('section.market-prices'))->name('market-prices');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.post');

    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store'])->name('register.post');

    Route::get('/forgot-password', [ForgotPasswordController::class, 'create'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'store'])->name('password.email');
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'create'])->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'store'])->name('password.store');

    Route::get('/verify-otp', [OtpController::class, 'create'])->name('otp.show');
    Route::post('/verify-otp', [OtpController::class, 'store'])->name('otp.verify');
    Route::post('/verify-otp/resend', [OtpController::class, 'resend'])->name('otp.resend');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    Route::get('/verify-email', [EmailVerificationPromptController::class, '__invoke'])->name('verification.notice');
    Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');
});
