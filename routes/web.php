<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;

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
	// return view('layouts.homes.index');
	return redirect('/login');
});
Route::get('/login', function()
{
	return view('auth.login');
})->name('login');

Route::post('/login', [LoginController::class, 'loginPost'])->name('login.post');
Route::get('/signup', 'HomeCtrl@signup');

Route::middleware(['auth'])->group(function()
{
	Route::get('/home', 'HomeCtrl@index')->name('home');
	Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

	// profile
	Route::get('profile', 'UserCtrl@profile')->name('profile');
	Route::get('profile/edit', 'UserCtrl@profileEdit')->name('profile.edit');
	Route::put('profile/update', 'UserCtrl@profileUpdate')->name('profile.update');

	//password change
	Route::get('/change_password', 'UserCtrl@changePassword')->name('user.password.change');
	Route::put('/change_password', 'UserCtrl@updatePassword')->name('user.change.password');
	
	//user routes
	Route::resource('/user', 'UserCtrl');

	/** -------------------- Resource Routes --------------- */
	Route::resource('filter', 'FilterCtrl');
	Route::resource('sub-filter', 'SubFilterCtrl');
	Route::resource('filter-item', 'FilterItemCtrl');
	Route::resource('course', 'CourseCtrl');
	Route::resource('department', 'DepartmentCtrl');
	Route::resource('semester', 'SemesterCtrl');
	Route::resource('subject', 'SubjectCtrl');
	Route::resource('chapter', 'ChapterCtrl');
	Route::resource('question', 'QuestionCtrl');
	Route::resource('answer-file', 'AnswerFileCtrl');
	Route::resource('label', 'LabelCtrl');
	Route::resource('paper', 'PaperCtrl');
	Route::resource('batch', 'BatchCtrl');

	/** -------------------- Custom Routes ------------------ */
	Route::controller(DepartmentCtrl::class)->group(function()
	{
		Route::get('get_departments/{course_id}', 'getDepartments');
	});

	Route::controller(SemesterCtrl::class)->group(function()
	{
		Route::get('get_semesters/{department_id}', 'getSemesters');
	});

	Route::controller(SubjectCtrl::class)->group(function()
	{
		Route::get('get_sems_subjects/{semester_id}', 'getSemsSubjects');
		Route::get('get_subjects/{department_id}', 'getSubjects');
	});

	Route::controller(QuestionCtrl::class)->group(function()
	{
		Route::get('view_question', 'viewQuestion')->name('question.view');
		Route::post('question_view', 'viewQuestionPost')->name('question.view.post');
		Route::post('check_question_exist', 'Questions')->name('questions.title');
	});

	Route::controller(ChapterCtrl::class)->group(function()
	{
		Route::get('get_chapters/{subject_id}', 'getChapters');
	});

	Route::controller(FilterCtrl::class)->group(function()
	{
		Route::get('get_filters/{course_id}', 'getFilters');
	});

	Route::controller(PaperCtrl::class)->group(function()
	{
		Route::get('paper/add-question/{paper_id}', 'addQuestion')->name('paper.add.question');
		Route::post('paper/add_to_paper', 'addToPaper')->name('paper.addtopaper');
	});
	
});

// cache clear
Route::get('reboot', function ()
{
  Artisan::call('cache:clear');
  Artisan::call('view:clear');
  Artisan::call('route:clear');
  Artisan::call('config:cache');
  Artisan::call('view:cache');
  dd('System Successfully Rebooted');
});