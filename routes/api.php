<?php

use App\Presentation\Http\Controllers\CommentsController;
use App\Presentation\Http\Controllers\CompanyController;
use App\Presentation\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

Route::controller(UsersController::class)->group(function () {
    Route::get('/users/{id}', 'get');
    Route::get('/users/{id}/avatar', 'getUserAvatar');
    Route::delete('/users/{id}/avatar', 'deleteUserAvatar');
    Route::post('/users', 'create');
    Route::post('/users/{id}', 'update');
    Route::delete('/users/{id}', 'delete');
});

Route::controller(CompanyController::class)->group(function () {
    Route::get('/company/top_rating', 'getTopCompanyByRating');
    Route::get('/company/{id}', 'get');
    Route::get('/company/{id}/rating', 'getCompanyRating');
    Route::get('/company/{id}/logo', 'getCompanyLogo');
    Route::delete('/company/{id}/logo', 'deleteCompanyLogo');
    Route::post('/company', 'create');
    Route::post('/company/{id}', 'update');
    Route::delete('/company/{id}', 'delete');
});

Route::controller(CommentsController::class)->group(function () {
    Route::get('/comments/{id}', 'get');
    Route::get('/comments/by_company/{id}', 'getCommentsByCompanyId');
    Route::post('/comments', 'create');
    Route::post('/comments/{id}', 'update');
    Route::delete('/comments/{id}', 'delete');
});
