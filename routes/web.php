<?php

use App\Exports\LeadReport;
use App\Exports\CompanyReport;
use App\Exports\StudentsReport;
use App\Exports\EmployeesReport;
use App\Exports\CompanyLeadReport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\UserController;
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
    // Login / admin
    return redirect('/admin/login');
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


Route::get('export/students', function () {
    return Excel::download(new StudentsReport, 'students.xlsx');
})->name('export.students');

Route::get('export/employees', function () {
    return Excel::download(new EmployeesReport, 'employees.xlsx');
})->name('export.employees');

Route::get('export/leads', function () {
    return Excel::download(new LeadReport, 'leads.xlsx');
})->name('export.leads');

Route::get('export/company-leads', function () {
    return Excel::download(new CompanyLeadReport, 'company-leads.xlsx');
})->name('export.company-leads');

Route::get('export/companies', function () {
    return Excel::download(new CompanyReport, 'companies.xlsx');
})->name('export.companies');
