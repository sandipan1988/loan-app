<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('dashboard');

Route::group(['middleware' => 'auth'], function () {
	Route::any('/member', [App\Http\Controllers\MemberController::class, 'index'])->name('member');
	Route::get('/add-member', [App\Http\Controllers\MemberController::class, 'add'])->name('add-member');
	Route::post('/save-member', [App\Http\Controllers\MemberController::class, 'save'])->name('save-member');
	Route::get('/edit-member/{member_id}', [App\Http\Controllers\MemberController::class, 'edit'])->name('edit-member');
	Route::post('/update-member/{member_id}', [App\Http\Controllers\MemberController::class, 'update'])->name('update-member');
	Route::get('/del-member/{member_id}', [App\Http\Controllers\MemberController::class, 'delete'])->name('del-member');
	Route::get('/member-download/{id}', [App\Http\Controllers\MemberController::class, 'getMember'])->name('member-download');

	Route::any('/loan', [App\Http\Controllers\LoanController::class, 'index'])->name('loan');
	Route::get('/add-loan', [App\Http\Controllers\LoanController::class, 'add'])->name('add-loan');
	Route::post('/submit-loan', [App\Http\Controllers\LoanController::class, 'post'])->name('submit-loan');
	Route::get('/edit-loan/{loan_id}', [App\Http\Controllers\LoanController::class, 'edit'])->name('edit-loan');
    Route::patch('/update-loan/{loan_id}', [App\Http\Controllers\LoanController::class, 'update'])->name('update-loan');
	Route::get('/del-loan/{loan_id}', [App\Http\Controllers\LoanController::class, 'delete'])->name('del-loan');
	Route::post('/find-by-name', [App\Http\Controllers\LoanController::class, 'findByName'])->name('find-by-name');
	Route::post('/close-loan', [App\Http\Controllers\LoanController::class, 'close_loan'])->name('close-loan');


	Route::get('/schedule', [App\Http\Controllers\ScheduleController::class, 'index'])->name('schedule');
    Route::get('/amortization-schedule/{id}', [App\Http\Controllers\LoanController::class, 'getScheduleById'])->name('amortization-schedule');
    Route::post('/submit-schedule', [App\Http\Controllers\ScheduleController::class, 'post'])->name('submit-schedule');
    Route::post('/search-schedule', [App\Http\Controllers\ScheduleController::class, 'search'])->name('search-schedule');
    Route::get('/amortization-schedule-download/{id}', [App\Http\Controllers\LoanController::class, 'getScheduleDownload'])->name('amortization-schedule-dowload');
    Route::get('/stmnt-download/{id}', [App\Http\Controllers\LoanController::class, 'getStatement'])->name('stmnt-download');
	Route::get('/due-report', [App\Http\Controllers\ReportController::class, 'getDues'])->name('due-report');
	Route::any('/interest-report', [App\Http\Controllers\ReportController::class, 'interest'])->name('interest-report');
	Route::get('/ledger/{member_id}', [App\Http\Controllers\ReportController::class, 'ledger'])->name('ledger');
	Route::any('/sale-report', [App\Http\Controllers\ReportController::class, 'saleReport'])->name('sale-report');
	Route::any('/due-report-search', [App\Http\Controllers\ReportController::class, 'searchDues'])->name('due-search');
	Route::get('due/export/', [App\Http\Controllers\ReportController::class, 'export'])->name('daily-export');
});

Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::patch('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	Route::patch('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
});

Route::group(['middleware' => 'auth'], function () {
	Route::get('{page}', ['as' => 'page.index', 'uses' => 'App\Http\Controllers\PageController@index']);
});

