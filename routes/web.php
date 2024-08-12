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
	Route::get('/member', [App\Http\Controllers\MemberController::class, 'index'])->name('member');
	Route::get('/add-member', [App\Http\Controllers\MemberController::class, 'add'])->name('add-member');
	Route::get('/edit-member', [App\Http\Controllers\MemberController::class, 'edit'])->name('edit-member');
	Route::get('/del-member', [App\Http\Controllers\MemberController::class, 'delete'])->name('del-member');

	Route::get('/loan', [App\Http\Controllers\LoanController::class, 'index'])->name('loan');
	Route::get('/add-loan', [App\Http\Controllers\LoanController::class, 'add'])->name('add-loan');
	Route::post('/submit-loan', [App\Http\Controllers\LoanController::class, 'post'])->name('submit-loan');
	Route::get('/edit-loan/{loan_id}', [App\Http\Controllers\LoanController::class, 'edit'])->name('edit-loan');
    Route::patch('/update-loan/{loan_id}', [App\Http\Controllers\LoanController::class, 'update'])->name('update-loan');
	Route::get('/del-loan', [App\Http\Controllers\LoanController::class, 'delete'])->name('del-loan');


	Route::get('/schedule', [App\Http\Controllers\ScheduleController::class, 'index'])->name('schedule');
    Route::get('/amortization-schedule/{id}', [App\Http\Controllers\LoanController::class, 'getScheduleById'])->name('amortization-schedule');



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

