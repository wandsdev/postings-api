<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PeriodController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\PostingController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function ($router) {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);

    Route::post('register', [AuthController::class, 'register']);
    Route::post('account_validation', [AuthController::class, 'accountValidation']);
    Route::post('resend_validation_code', [AuthController::class, 'resendValidationCode']);

    Route::post('forgot_password', [AuthController::class, 'forgotPassword']);
    Route::post('reset_password', [AuthController::class, 'resetPassword']);

});

Route::group(['middleware' => 'auth:api'], function ($router) {
    Route::get('/people', [PersonController::class, 'findAll'])->name('people.findAll');
    Route::post('/people', [PersonController::class, 'create'])->name('people.create');
    Route::put('/people/{id}', [PersonController::class, 'update'])->name('people.update');
    Route::delete('/people/{id}', [PersonController::class, 'delete'])->name('people.delete');

    Route::get('/postings', [PostingController::class, 'findAll'])->name('postings.findAll');
    Route::get('/postings/{id}', [PostingController::class, 'find'])->name('postings.find');
    Route::post('/postings', [PostingController::class, 'create'])->name('postings.create');
    Route::put('/postings/{id}', [PostingController::class, 'update'])->name('postings.update');
    Route::delete('/postings/{id}', [PostingController::class, 'delete'])->name('postings.delete');

    Route::get('/periods', [PeriodController::class, 'findAll'])->name('periods.findAll');
    Route::post('/periods', [PeriodController::class, 'create'])->name('periods.create');
    Route::put('/periods/{id}', [PeriodController::class, 'update'])->name('periods.update');
    Route::delete('/periods/{id}', [PeriodController::class, 'delete'])->name('periods.delete');

    Route::get('user', [UserController::class, 'find']);
    Route::put('/user', [UserController::class, 'update'])->name('user.update');
    Route::put('/user/password', [UserController::class, 'updatePassword'])->name('user.update.password');
    Route::post('/user/photo', [UserController::class, 'savePhoto'])->name('user.photo');
});
