<?php

use Illuminate\Support\Facades\Route;

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


Route::get('/clear-cache', function() {
	//dd(bcrypt('123456'));
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    return "Cache is cleared";
});

Route::get('lang-file/{lang}', function($locale){
	App::setLocale($locale);
	return view('lang');	
});

// Route::get('/admin', function () {
//     return view('welcome');
// })->name('login');

Route::get('/register', 'Auth\AuthController@register')->name('register');
Route::post('/register', 'Auth\AuthController@storeUser');
Route::get('/login', 'Auth\AuthController@index')->name('login');
//Route::post('/login', 'Auth\AuthController@authenticate');
Route::any('userlogin','Auth\AuthController@authenticate');
Route::post('search-posts','Auth\AuthController@searchPost');
Route::any('set-session-lg', 'Auth\AuthController@setSession');
Route::get('/user/verify/{id}', 'Auth\AuthController@verifyUser');

Route::group(['middleware' => 'CheckUserLogin'], function () {
Route::get('/post/{id}', 'Auth\AuthController@postDetaile');
Route::get('logout', 'Auth\AuthController@logout')->name('logout');
Route::get('/home', 'Auth\AuthController@home')->name('home');
});
//Admin routes
Route::namespace('Admin')->prefix('admin')->group(function(){
	Route::any('change-status', 'AjaxController@changeStatus');
	Route::post('check-email', 'AjaxController@mksCheckEmail');
    Route::post('check-mobile', 'AjaxController@mksCheckMobile');
    
	Route::post('hard-delete', 'AjaxController@hardDelete');
	Route::get('/', 'AuthController@login')->name('login');
	Route::get('/login', 'AuthController@login')->name('login');
	Route::post('/login', 'AuthController@postLogin')->name('login-post');
	Route::get('forget-password', 'AuthController@getForgotPasswordForm'); // For get Form
	Route::post('recover-password', 'AuthController@getForgetPasswordToken'); // For send Mail
	Route::get('reset-forgot-password', 'AuthController@getNewPasswordForm'); // For get new password Form
	Route::post('reset-forgot-password', 'AuthController@updateNewPassword'); // For updatenew Password
});

// Admin route after succussfully login
Route::namespace('Admin')->prefix('admin')->as('admin.')->middleware('auth:web')->group(function
(){
	// Admin route after succussfully login
	Route::get('/dashboard', 'AuthController@dashboard')->name('dashboard');
	Route::group(['prefix' => 'users'], function () {
		Route::get('/', 'UserController@index');
		Route::get('create', 'UserController@create');
		Route::post('store', 'UserController@store');
		Route::get('{id}/edit', 'UserController@edit');
		Route::post('update', 'UserController@update');
		Route::get('show-details/{id}', 'UserController@show');
		Route::post('hard-delete', 'UserController@userDelete');
	});

   Route::group(['prefix' => 'products'], function () {
		Route::get('/', 'ProductController@index');
		Route::get('create', 'ProductController@create');
		Route::post('store', 'ProductController@store');
		Route::get('{id}/edit', 'ProductController@edit');
		Route::post('update', 'ProductController@update');
		Route::get('show-details/{id}', 'ProductController@show');
		Route::post('hard-delete', 'ProductController@productDelete');
	});

	Route::group(['prefix' => 'categories'], function () {
		Route::get('/', 'CategoryController@index');
		Route::get('create', 'CategoryController@create');
		Route::post('store', 'CategoryController@store');
		Route::get('{id}/edit', 'CategoryController@edit');
		Route::post('update', 'CategoryController@update');
		Route::get('show-details/{id}', 'CategoryController@show');
		Route::post('hard-delete', 'CategoryController@categoryDelete');
	});

	Route::group(['prefix' => 'posts'], function () {
		Route::get('/', 'PostController@index');
		Route::get('create', 'PostController@create');
		Route::post('store', 'PostController@store');
		Route::get('{id}/edit', 'PostController@edit');
		Route::post('update', 'PostController@update');
		Route::get('show-details/{id}', 'PostController@show');
		Route::post('hard-delete', 'PostController@postDelete');
	});
	
	
	Route::get('logout', 'AuthController@logout');
	Route::get('profile', 'AuthController@changePasswordProfile');
	Route::post('update-profile', 'AuthController@updateProfile');
	Route::post('update-password', 'AuthController@updatePassword'); // For updatenew 
});
