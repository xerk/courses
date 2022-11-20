<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\LeadController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\FollowUpController;
use App\Http\Controllers\Api\UserLeadsController;
use App\Http\Controllers\Api\AssigmentController;
use App\Http\Controllers\Api\UserCoursesController;
use App\Http\Controllers\Api\CourseUsersController;
use App\Http\Controllers\Api\CompanyLeadController;
use App\Http\Controllers\Api\CourseGroupController;
use App\Http\Controllers\Api\SubCategoryController;
use App\Http\Controllers\Api\CompanyUsersController;
use App\Http\Controllers\Api\CategoryUsersController;
use App\Http\Controllers\Api\CategoryLeadsController;
use App\Http\Controllers\Api\LeadFollowUpsController;
use App\Http\Controllers\Api\UserAssigmentsController;
use App\Http\Controllers\Api\CompanyCoursesController;
use App\Http\Controllers\Api\CategoryCoursesController;
use App\Http\Controllers\Api\CompanyTrainersController;
use App\Http\Controllers\Api\CourseCompaniesController;
use App\Http\Controllers\Api\AssigmentAnswerController;
use App\Http\Controllers\Api\UserCourseGroupsController;
use App\Http\Controllers\Api\UserCompanyLeadsController;
use App\Http\Controllers\Api\CourseGroupUsersController;
use App\Http\Controllers\Api\SubCategoryLeadsController;
use App\Http\Controllers\Api\CourseCourseGroupsController;
use App\Http\Controllers\Api\UserAssigmentAnswersController;
use App\Http\Controllers\Api\CategoryCompanyLeadsController;
use App\Http\Controllers\Api\CompanyLeadFollowUpsController;
use App\Http\Controllers\Api\CategorySubCategoriesController;
use App\Http\Controllers\Api\CourseGroupAssigmentsController;
use App\Http\Controllers\Api\SubCategoryCompanyLeadsController;
use App\Http\Controllers\Api\AssigmentAssigmentAnswersController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', [AuthController::class, 'login'])->name('api.login');

Route::middleware('auth:sanctum')
    ->get('/user', function (Request $request) {
        return $request->user();
    })
    ->name('api.user');

Route::name('api.')
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::apiResource('users', UserController::class);

        // User Assigments
        Route::get('/users/{user}/assigments', [
            UserAssigmentsController::class,
            'index',
        ])->name('users.assigments.index');
        Route::post('/users/{user}/assigments', [
            UserAssigmentsController::class,
            'store',
        ])->name('users.assigments.store');

        // User Course Groups
        Route::get('/users/{user}/course-groups', [
            UserCourseGroupsController::class,
            'index',
        ])->name('users.course-groups.index');
        Route::post('/users/{user}/course-groups', [
            UserCourseGroupsController::class,
            'store',
        ])->name('users.course-groups.store');

        // User Assigment Answers
        Route::get('/users/{user}/assigment-answers', [
            UserAssigmentAnswersController::class,
            'index',
        ])->name('users.assigment-answers.index');
        Route::post('/users/{user}/assigment-answers', [
            UserAssigmentAnswersController::class,
            'store',
        ])->name('users.assigment-answers.store');

        // User Leads
        Route::get('/users/{user}/leads', [
            UserLeadsController::class,
            'index',
        ])->name('users.leads.index');
        Route::post('/users/{user}/leads', [
            UserLeadsController::class,
            'store',
        ])->name('users.leads.store');

        // User Company Leads
        Route::get('/users/{user}/company-leads', [
            UserCompanyLeadsController::class,
            'index',
        ])->name('users.company-leads.index');
        Route::post('/users/{user}/company-leads', [
            UserCompanyLeadsController::class,
            'store',
        ])->name('users.company-leads.store');

        // User Courses
        Route::get('/users/{user}/courses', [
            UserCoursesController::class,
            'index',
        ])->name('users.courses.index');
        Route::post('/users/{user}/courses/{course}', [
            UserCoursesController::class,
            'store',
        ])->name('users.courses.store');
        Route::delete('/users/{user}/courses/{course}', [
            UserCoursesController::class,
            'destroy',
        ])->name('users.courses.destroy');

        // User Course Groups2
        Route::get('/users/{user}/course-groups', [
            UserCourseGroupsController::class,
            'index',
        ])->name('users.course-groups.index');
        Route::post('/users/{user}/course-groups/{courseGroup}', [
            UserCourseGroupsController::class,
            'store',
        ])->name('users.course-groups.store');
        Route::delete('/users/{user}/course-groups/{courseGroup}', [
            UserCourseGroupsController::class,
            'destroy',
        ])->name('users.course-groups.destroy');

        Route::apiResource('categories', CategoryController::class);

        // Category Users
        Route::get('/categories/{category}/users', [
            CategoryUsersController::class,
            'index',
        ])->name('categories.users.index');
        Route::post('/categories/{category}/users', [
            CategoryUsersController::class,
            'store',
        ])->name('categories.users.store');

        // Category Courses
        Route::get('/categories/{category}/courses', [
            CategoryCoursesController::class,
            'index',
        ])->name('categories.courses.index');
        Route::post('/categories/{category}/courses', [
            CategoryCoursesController::class,
            'store',
        ])->name('categories.courses.store');

        // Category Leads
        Route::get('/categories/{category}/leads', [
            CategoryLeadsController::class,
            'index',
        ])->name('categories.leads.index');
        Route::post('/categories/{category}/leads', [
            CategoryLeadsController::class,
            'store',
        ])->name('categories.leads.store');

        // Category Company Leads
        Route::get('/categories/{category}/company-leads', [
            CategoryCompanyLeadsController::class,
            'index',
        ])->name('categories.company-leads.index');
        Route::post('/categories/{category}/company-leads', [
            CategoryCompanyLeadsController::class,
            'store',
        ])->name('categories.company-leads.store');

        // Category Sub Categories
        Route::get('/categories/{category}/sub-categories', [
            CategorySubCategoriesController::class,
            'index',
        ])->name('categories.sub-categories.index');
        Route::post('/categories/{category}/sub-categories', [
            CategorySubCategoriesController::class,
            'store',
        ])->name('categories.sub-categories.store');

        Route::apiResource('companies', CompanyController::class);

        // Company Users
        Route::get('/companies/{company}/users', [
            CompanyUsersController::class,
            'index',
        ])->name('companies.users.index');
        Route::post('/companies/{company}/users', [
            CompanyUsersController::class,
            'store',
        ])->name('companies.users.store');

        // Company Trainers
        Route::get('/companies/{company}/trainers', [
            CompanyTrainersController::class,
            'index',
        ])->name('companies.trainers.index');
        Route::post('/companies/{company}/trainers', [
            CompanyTrainersController::class,
            'store',
        ])->name('companies.trainers.store');

        // Company Courses
        Route::get('/companies/{company}/courses', [
            CompanyCoursesController::class,
            'index',
        ])->name('companies.courses.index');
        Route::post('/companies/{company}/courses/{course}', [
            CompanyCoursesController::class,
            'store',
        ])->name('companies.courses.store');
        Route::delete('/companies/{company}/courses/{course}', [
            CompanyCoursesController::class,
            'destroy',
        ])->name('companies.courses.destroy');

        Route::apiResource('courses', CourseController::class);

        // Course Course Groups
        Route::get('/courses/{course}/course-groups', [
            CourseCourseGroupsController::class,
            'index',
        ])->name('courses.course-groups.index');
        Route::post('/courses/{course}/course-groups', [
            CourseCourseGroupsController::class,
            'store',
        ])->name('courses.course-groups.store');

        // Course Users
        Route::get('/courses/{course}/users', [
            CourseUsersController::class,
            'index',
        ])->name('courses.users.index');
        Route::post('/courses/{course}/users/{user}', [
            CourseUsersController::class,
            'store',
        ])->name('courses.users.store');
        Route::delete('/courses/{course}/users/{user}', [
            CourseUsersController::class,
            'destroy',
        ])->name('courses.users.destroy');

        // Course Companies
        Route::get('/courses/{course}/companies', [
            CourseCompaniesController::class,
            'index',
        ])->name('courses.companies.index');
        Route::post('/courses/{course}/companies/{company}', [
            CourseCompaniesController::class,
            'store',
        ])->name('courses.companies.store');
        Route::delete('/courses/{course}/companies/{company}', [
            CourseCompaniesController::class,
            'destroy',
        ])->name('courses.companies.destroy');

        Route::apiResource('leads', LeadController::class);

        // Lead Follow Ups
        Route::get('/leads/{lead}/follow-ups', [
            LeadFollowUpsController::class,
            'index',
        ])->name('leads.follow-ups.index');
        Route::post('/leads/{lead}/follow-ups', [
            LeadFollowUpsController::class,
            'store',
        ])->name('leads.follow-ups.store');

        Route::apiResource('company-leads', CompanyLeadController::class);

        // CompanyLead Follow Ups
        Route::get('/company-leads/{companyLead}/follow-ups', [
            CompanyLeadFollowUpsController::class,
            'index',
        ])->name('company-leads.follow-ups.index');
        Route::post('/company-leads/{companyLead}/follow-ups', [
            CompanyLeadFollowUpsController::class,
            'store',
        ])->name('company-leads.follow-ups.store');

        Route::apiResource('course-groups', CourseGroupController::class);

        // CourseGroup Assigments
        Route::get('/course-groups/{courseGroup}/assigments', [
            CourseGroupAssigmentsController::class,
            'index',
        ])->name('course-groups.assigments.index');
        Route::post('/course-groups/{courseGroup}/assigments', [
            CourseGroupAssigmentsController::class,
            'store',
        ])->name('course-groups.assigments.store');

        // CourseGroup Users
        Route::get('/course-groups/{courseGroup}/users', [
            CourseGroupUsersController::class,
            'index',
        ])->name('course-groups.users.index');
        Route::post('/course-groups/{courseGroup}/users/{user}', [
            CourseGroupUsersController::class,
            'store',
        ])->name('course-groups.users.store');
        Route::delete('/course-groups/{courseGroup}/users/{user}', [
            CourseGroupUsersController::class,
            'destroy',
        ])->name('course-groups.users.destroy');

        Route::apiResource('assigments', AssigmentController::class);

        // Assigment Assigment Answers
        Route::get('/assigments/{assigment}/assigment-answers', [
            AssigmentAssigmentAnswersController::class,
            'index',
        ])->name('assigments.assigment-answers.index');
        Route::post('/assigments/{assigment}/assigment-answers', [
            AssigmentAssigmentAnswersController::class,
            'store',
        ])->name('assigments.assigment-answers.store');

        Route::apiResource(
            'assigment-answers',
            AssigmentAnswerController::class
        );

        Route::apiResource('sub-categories', SubCategoryController::class);

        // SubCategory Leads
        Route::get('/sub-categories/{subCategory}/leads', [
            SubCategoryLeadsController::class,
            'index',
        ])->name('sub-categories.leads.index');
        Route::post('/sub-categories/{subCategory}/leads', [
            SubCategoryLeadsController::class,
            'store',
        ])->name('sub-categories.leads.store');

        // SubCategory Company Leads
        Route::get('/sub-categories/{subCategory}/company-leads', [
            SubCategoryCompanyLeadsController::class,
            'index',
        ])->name('sub-categories.company-leads.index');
        Route::post('/sub-categories/{subCategory}/company-leads', [
            SubCategoryCompanyLeadsController::class,
            'store',
        ])->name('sub-categories.company-leads.store');
    });
