<?php

use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\CompanyCallController;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\ForumController;
use App\Http\Controllers\Api\JobsController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

Route::post('register', RegisterController::class);
Route::post('login', [AuthController::class, 'login']);
Route::get('forums', [ForumController::class, 'index']);
Route::get('forums/{forum}', [ForumController::class, 'show']);

Route::group(['middleware' => 'auth:api'], function ($router) {
    //route for auth
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    //route for forum post

    Route::post('forums', [ForumController::class, 'store']);
    Route::put('forums/{forum}', [ForumController::class, 'update']);
    Route::delete('forums/{forum}', [ForumController::class, 'destroy']);
    //route for forum comments
    Route::post('forums/{forum}/comments', [CommentController::class, 'store']);
    Route::put('forums/{forum}/comments/{comment}', [CommentController::class, 'update']);
    Route::delete('forums/{forum}/comments/{comment}', [CommentController::class, 'destroy']);
    //route for user profile
    Route::get('user', [ProfileController::class, 'me']);
    Route::put('user/{id}', [ProfileController::class, 'profile']);
    Route::post('changepassword', [ProfileController::class, 'updatePassword']);

    Route::group(['middleware' => 'isAdmin'], function ($router) {
        Route::get('jobs', [JobsController::class, 'index']); //show all jobs
        Route::post('jobs', [JobsController::class, 'store']);
        Route::get('jobs/{job}', [JobsController::class, 'show']);
        Route::put('jobs/{job}', [JobsController::class, 'update']);
        Route::post('job/import', [JobsController::class, 'import']);
        Route::get('job/export', [JobsController::class, 'export']);
        Route::delete('jobs/{job}', [JobsController::class, 'destroy']);
        Route::delete('job/delete', [JobsController::class, 'deleteAll']);
        //route for company
        Route::get('company', [CompanyController::class, 'index']); //show all company
        Route::get('company/{company}', [CompanyController::class, 'show']);
        Route::get('companies/export', [CompanyController::class, 'exportExcel']);
        Route::get('companies', CompanyCallController::class);
        Route::post('company', [CompanyController::class, 'store']);
        Route::post('company/import', [CompanyController::class, 'import']);
        Route::put('company/{company}', [CompanyController::class, 'update']);
        Route::delete('company/{company}', [CompanyController::class, 'destroy']);
        Route::delete('companies/delete', [CompanyController::class, 'deleteAll']);
        //all user route
        Route::get('users', [UserController::class, 'index']);
        //all total count data
        Route::get('dashboard', DashboardController::class);
    });
});
