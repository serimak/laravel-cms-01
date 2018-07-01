<?php
use Illuminate\Http\Request;
use GuzzleHttp\Exception\RequestException;
if (env('REDIRECT_HTTPS') == 'true' || env('REDIRECT_HTTPS') == true) {
    \URL::forceScheme('https');
}else{
    \URL::forceScheme('http');
}
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
	return view('guest');
});

Route::get('login', function () {
	return view('login');
})->name('login');

Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');

Route::post('auth/guest', 'Auth\AuthController@postGuest');

Route::group(['middleware' => ['role.user']], function () {

	Route::get('auth/logout', 'Auth\AuthController@getLogout')->name('logout');
	Route::get('auth/guestlogout', 'Auth\AuthController@getGuestLogout')->name('logoutguest');

	Route::get('dashboard', function () {
	  	return view('dashboard');
	})->name('home');

	Route::group(['prefix' => 'research_chart'], function() {
		Route::get('', 'ChartController@index')->name('resChart');
	});

	Route::group(['prefix' => 'change_password'], function() {
		Route::get('', 'ProfileController@change_password')->name('change_password');
		Route::post('', 'ProfileController@change_password');
	});

	Route::group(['prefix' => 'menu_management'], function() {
		Route::get('', 'MenuController@index')->name('menu');
	});

	Route::group(['prefix' => 'profile'], function() {
		Route::get('', 'ProfileController@index')->name('profile');
		Route::post('', 'ProfileController@index');
	});

	Route::group(['prefix' => 'research_registration'], function() {
		Route::get('', 'ResRegistrationController@index')->name('resRegis');
		Route::get('add', 'ResRegistrationController@create')->name('resRegis.add');
		Route::post('add', 'ResRegistrationController@create');
		Route::get('edit/{id}', 'ResRegistrationController@edit')->where('id', '[0-9]+')->name('resRegis.edit');
		Route::post('edit/{id}', 'ResRegistrationController@edit')->where('id', '[0-9]+');
		Route::post('selected', 'ResRegistrationController@update');
		Route::get('view/{id}', 'ResRegistrationController@view')->where('id', '[0-9]+')->name('resRegis.view');
	});

	Route::group(['prefix' => 'research_search'], function() {
		Route::get('', 'SerRegistrationController@index')->name('serRegis');
		Route::get('view/{id}', 'SerRegistrationController@view')->where('id', '[0-9]+')->name('serRegis.view');
	});

	Route::group(['prefix' => 'users_groups'], function() {
		Route::group(['prefix' => 'user'], function() {
			Route::get('', 'UsersController@index')->name('user');
			Route::get('add', 'UsersController@create')->name('user.add');
			Route::post('add', 'UsersController@create');
			Route::get('edit/{id}', 'UsersController@edit')->where('id', '[0-9]+')->name('user.edit');
			Route::post('edit/{id}', 'UsersController@edit')->where('id', '[0-9]+');
			Route::post('selected', 'UsersController@update');
		});

		Route::group(['prefix' => 'group'], function() {
			Route::get('', 'GroupsController@index')->name('group');
			Route::get('add', 'GroupsController@create')->name('group.add');
			Route::post('add', 'GroupsController@create');
			Route::get('edit/{id}', 'GroupsController@edit')->where('id', '[0-9]+')->name('group.edit');
			Route::post('edit/{id}', 'GroupsController@edit')->where('id', '[0-9]+');
			Route::post('selected', 'GroupsController@update');
		});

	});

});
