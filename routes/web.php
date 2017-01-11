<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
 */

Auth::routes();
Route::get('/', function () {
	return redirect('/admin/home');
});
Route::get('/home', function () {
	return redirect('/admin/home');
});

Route::group(['middleware' => ['auth'], 'prefix' => 'admin'], function () {

	Route::get('/home', 'HomeController@index');

	/* Start - Rotas para Financeiro*/
	Route::get('/lancamentos/balanco/{month?}/{year?}', 'Modules\Financial\BalanceController@index');
	Route::get('/lancamentos/{type}/{month?}/{year?}', 'Modules\Financial\ReleaseController@index');
	
        // Lançamentos
	Route::post('/release/edit', 'Modules\Financial\ReleaseController@update');
	Route::post('/release/delete', 'Modules\Financial\ReleaseController@destroy');
	Route::post('/release/efective', 'Modules\Financial\ReleaseController@efective');
	Route::post('/release/create', 'Modules\Financial\ReleaseController@store');

	// Contas
	Route::get('/contas', 'Modules\Financial\AccountController@index');
	Route::post('/account/create', 'Modules\Financial\AccountController@store');
	Route::post('/account/edit', 'Modules\Financial\AccountController@update');
	Route::post('/account/delete', 'Modules\Financial\AccountController@destroy');
	Route::post('/account/transfer', 'Modules\Financial\AccountController@transfer');
	
	/* End - Rotas para Financeiro*/

	/* Start - Rotas para Configuração*/
	Route::get('/config/categorias', 'Modules\Financial\CategoryController@index');
	Route::post('/config/categorias/create', 'Modules\Financial\CategoryController@store');
	Route::post('/config/categorias/update', 'Modules\Financial\CategoryController@update');
	Route::post('/config/categorias/delete', 'Modules\Financial\CategoryController@destroy');
	/* End - Rotas para Configuração*/


	Route::post('/usuario/pass/reset', 'Modules\Register\UserController@passReset');

	Route::resource('usuario', 'Modules\Register\UserController', ['only' => ['index', 'update', 'destroy', 'store']]);
});

