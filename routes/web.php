<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BoarderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RoomsController;


use App\Http\Controllers\Boarders\BoarderDashboardController;
use App\Http\Controllers\Boarders\BoarderProfileController;
use App\Http\Controllers\Boarders\OnlinePaymentController;
use App\Http\Controllers\Boarders\ReferralController;
use App\Http\Controllers\Boarders\DocumentController;
use App\Http\Controllers\Boarders\BoarderPaymentController;
use App\Http\Controllers\Boarders\PaymentTrackingController;
use App\Http\Controllers\ApplicationController;

Route::get('/', function () {
    return view('main.hero');
});
Route::get('/about', function(){
    return view('main.about');
});

Route::get('/room', [RoomsController::class, 'displayRooms']);

Route::get('/contact', [UserController::class, 'showContactForm'])->name('contact');
Route::post('/contact', [UserController::class, 'sendContactMessage']);

// Admin Auth Routes
Route::group(['auth:web'], function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/logout', [UserController::class, 'logout'])->name('logout');
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot.password');
    Route::get('reset-password/{token}', [AuthController::class, 'showResetForm'])->name('reset.password.form');
    Route::post('update-password', [AuthController::class, 'updatePassword'])->name('update.password');

    Route::get('login/google', [AuthController::class, 'redirectToGoogle']);
    Route::get('login/google/callback', [AuthController::class, 'handleGoogleCallback']);

    Route::get('/apply', [ApplicationController::class, 'create'])->name('applications.create');
    Route::post('/apply', [ApplicationController::class, 'store'])->name('applications.store');

});

// Admin Routes Middleware
Route::middleware(['auth:web'])->group(function () {
    // Dashboard and Profile Routes
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [UserController::class, 'showProfile'])->name('profile');
    Route::post('/profile/update', [UserController::class, 'updateAdminProfile'])->name('updateAdminProfile');

    // Boarders Routes
    Route::get('/boarders', [BoarderController::class, 'index'])->name('boarders.index');
    Route::post('/boarders', [BoarderController::class, 'store'])->name('boarders.store');
    Route::get('/boarders/{boarder}/edit', [BoarderController::class, 'edit'])->name('boarders.edit');
    Route::put('/boarders/{boarder}', [BoarderController::class, 'update'])->name('boarders.update');
    Route::delete('/boarders/{boarder}', [BoarderController::class, 'destroy'])->name('boarders.destroy');

    // Rooms Routes
    Route::get('/rooms', [RoomsController::class, 'index'])->name('rooms.index');
    Route::post('/rooms', [RoomsController::class, 'store'])->name('rooms.store');
    Route::get('/rooms/{room}/edit', [RoomsController::class, 'edit'])->name('rooms.edit');
    Route::put('/rooms/{room}', [RoomsController::class, 'update'])->name('rooms.update');
    Route::delete('/rooms/{room}', [RoomsController::class, 'destroy'])->name('rooms.destroy');

    // Payments Routes
    Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
    Route::post('/payments', [PaymentController::class, 'store'])->name('payments.store');
    Route::post('payments/{paymentId}/partial', [PaymentController::class, 'partialPayment'])->name('payments.partialPayment');
    Route::delete('/payments/{payment}', [PaymentController::class, 'delete'])->name('payments.destroy');
    Route::get('/history', [PaymentController::class, 'history'])->name('history');

    //  Applicant's Route
    Route::get('/manage-applicants', [ApplicationController::class, 'manageApplicants'])->name('manage.applicants');
    Route::put('/update-applicant-status/{id}', [ApplicationController::class, 'updateStatus'])->name('update.applicant.status');

});

// Boarders Portal Route Middleware
Route::middleware(['auth:boarders'])->group(function () {
    // Dashboard
    Route::get('/boarderdashboard', [BoarderDashboardController::class, 'index'])->name('boarders.boarderdashboard');

    // Profile
    Route::get('/boarders/profile', [BoarderProfileController::class, 'show'])->name('boarders.profile');
    Route::post('/boarders/profile/update', [BoarderProfileController::class, 'updateProfile'])->name('boarders.updateProfile');

    // Online Payment
    Route::get('/online-payment', [OnlinePaymentController::class, 'index'])->name('boarders.online-payment');
    Route::post('/online-payment/process', [OnlinePaymentController::class, 'process'])->name('boarders.online-payment.process');
    Route::get('/online-payment/{paymentId}/pay', [OnlinePaymentController::class, 'createPaymentLink'])->name('payment.pay');
    Route::get('/online-payment/success', [OnlinePaymentController::class, 'handleSuccessfulPayment'])->name('payments.success');
    Route::get('/online-payment/cancel', [OnlinePaymentController::class, 'handleCancelledPayment'])->name('payments.cancel');

    // Referral
    Route::get('/referral', [ReferralController::class, 'index'])->name('boarders.referral');
    Route::post('/referral/send', [ReferralController::class, 'send'])->name('boarders.referral.send');
    Route::post('/redeem-discount', [ReferralController::class, 'redeemDiscount'])->name('redeem.discount');

    // Document Uploads
    Route::get('/documents', [DocumentController::class, 'index'])->name('boarders.documents');
    Route::post('/documents/upload', [DocumentController::class, 'upload'])->name('boarders.documents.upload');
    Route::delete('/documents/{document}', [DocumentController::class, 'destroy'])->name('boarders.documents.destroy');

    // Payment History & Receipts
    Route::get('/boarder-payments-history', [BoarderPaymentController::class, 'history'])->name('boarders.payments-history');
});



