<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AssigmentController;
use App\Http\Controllers\CompanyLeadController;
use App\Http\Controllers\CourseGroupController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\AssigmentAnswerController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('/')
    ->middleware('auth')
    ->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('categories', CategoryController::class);
        Route::resource('companies', CompanyController::class);
        Route::resource('courses', CourseController::class);
        Route::resource('leads', LeadController::class);
        Route::resource('company-leads', CompanyLeadController::class);
        Route::resource('course-groups', CourseGroupController::class);
        Route::resource('assigments', AssigmentController::class);
        Route::resource('assigment-answers', AssigmentAnswerController::class);
        Route::resource('sub-categories', SubCategoryController::class);
    });
Route::get('download-assigment/{id}', [UserController::class, 'downloadAssigment'])->name('download.assigment');