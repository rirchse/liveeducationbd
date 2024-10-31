<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\StudentLogin;
use App\Http\Controllers\Students\StudentHomeCtrl;

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
Route::controller(RegisterController::class)->group(function()
{
	Route::get('/signup', 'signup')->name('register');
	Route::post('/signup', 'signupPost')->name('register.post');
	Route::get('/account_verify/{code}', 'verify')->name('email.verify');
	// Route::get('/verification', '')
});
Route::get('students', function(){
	return '<p style="text-align:center;margin-top:20%">Welcome to Student Panel</p>';
})->name('students');
Route::controller(StudentLogin::class)->group(function()
{
	Route::get('students/login', 'login')->name('students.login');
	Route::post('students/login', 'loginPost')->name('students.login.post');
	Route::post('students/logout', 'logout')->name('students.logout');
});

Route::middleware('auth:student')->group(function()
{
	Route::controller(StudentHomeCtrl::class)->group(function()
	{
		Route::get('students/home', 'home')->name('students.home');
		Route::get('students/exam', 'exam')->name('students.exam');
		Route::get('students/exam/{id}', 'examShow')->name('students.exam.show');
		Route::get('students/course', 'course')->name('students.course');
		Route::get('students/course/{id}', 'courseShow')->name('students.course.show');
		Route::post('students/course-apply', 'applyCourse')->name('students.course.apply');
		Route::get('students/my-course', 'myCourse')->name('students.my-course');
		Route::post('student/exam_add', 'examAdd')->name('student.exam.add');
	});
});

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
	Route::resource('group', 'GroupCtrl');
	Route::resource('student', 'StudentCtrl');

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
		Route::get('/paper/view/{id}', 'view')->name('paper.view');
	});

	Route::controller(StudentCtrl::class)->group(function()
	{
		Route::get('add-students/{id}/{name}', 'addStudent')->name('students.add');
		Route::post('add-student-object', 'addStudentObject')->name('students.add.object');
		Route::get('add-student-complete', 'addStudentComplete')->name('students.add.complete');
		Route::get('student/view/{id}/{name}', 'view')->name('student.view');
		Route::get('student/remove/{id}/{name}/{obj}', 'remove')->name('student.remove');
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