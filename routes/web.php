<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Staff\AuthController;
use App\Http\Controllers\BorrowerController;
use App\Http\Controllers\BorrowerLoginController;
use App\Http\Controllers\BorrowerLoanController;

Route::get('/', function () {
    return view('welcome'); // or 'index' depending on your filename
})->name('home');

// About Page
Route::get('/about', function () {
    return view('about');
})->name('about');

// Shop Page
Route::get('/shop', function () {
    return view('shop');
})->name('shop');

// Contact Page
Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/history', function () {
    return view('history');
})->name('history');
Route::get('/staff/login', [AuthController::class, 'showLogin'])->name('staff.login');
Route::post('/staff/login', [AuthController::class, 'login'])->name('staff.login.submit');

Route::get('/dashboard', [AuthController::class, 'showStaffDashboard'])->name('staff.dashboard');
Route::post('/logout', [AuthController::class, 'logout'])->name('staff.logout');

Route::post('/profile/update-image', [AuthController::class, 'updateProfileImage'])
    ->name('staff.profile.update');
Route::get('/profile', [AuthController::class, 'profile'])->name('admin.profile');
Route::get('/borrowers', [BorrowerController::class, 'index'])->name('borrowers.list');
Route::post('/savings-accounts', [BorrowerController::class, 'store'])->name('accounts.store');
Route::put('/savings-accounts/{id}', [BorrowerController::class, 'update'])->name('accounts.update');
Route::delete('/savings-accounts/{id}', [BorrowerController::class, 'destroy'])->name('accounts.destroy');

Route::get('/borrower/login', [BorrowerLoginController::class, 'showLoginForm'])->name('borrower.login');
Route::post('/borrower/login', [BorrowerLoginController::class, 'loginSubmit'])->name('borrower.login.submit');
Route::post('/borrower/logout', [BorrowerLoginController::class, 'logout'])->name('borrower.logout');
Route::post('/loan/repay/{loanId}', [BorrowerLoanController::class, 'processRepayment'])->name('loan.repay');
Route::get('/borrower/loan', [BorrowerLoanController::class, 'create'])->name('borrower.loan');

// လျှောက်လွှာ Data များကို Store လုပ်ရန် Route
Route::post('/borrower/loan/store', [BorrowerLoanController::class, 'store'])->name('borrower.loan.store');
Route::get('/borrower/loan/history', [BorrowerLoanController::class, 'history'])->name('borrower.loan.history');

Route::get('/loans/index', [BorrowerLoanController::class, 'index'])->name('loans.index');
Route::put('/loans/{id}/sstatus', [BorrowerLoanController::class, 'updateStatus'])->name('staff.loans.updateStatus');

Route::get('/loan/repay-detail/{id}', [BorrowerLoanController::class, 'showRepaymentDetail'])->name('loan.repay.detail');
Route::post('/loan/repay/process/{id}', [BorrowerLoanController::class, 'processPayment'])->name('loan.repay.process');
Route::get('/loan-repayments', [BorrowerLoanController::class, 'loanPaidList'])->name('loans.repayments');
Route::put('/loans/{id}/status', [BorrowerLoanController::class, 'updateStatusReaminder'])->name('loans.updateStatus');
