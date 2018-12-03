<?php
	
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
	
	Route::get( '/', function () {
		return redirect( route('home') );
	} );
	
	Auth::routes();
	
	
	Route::middleware('auth')->prefix('admin')->group( function () {
		Route::get( '/home-test', 'HomeController@index' )->name('home-test');
		Route::get( '/home', 'TodosController@index' )->name('home');
		Route::post('todo/store', 'TodosController@store')->name('todo.store');
		Route::post('todo/update', 'TodosController@update')->name('todo.update');
		Route::post('todo/destroy', 'TodosController@destroy')->name('todo.destroy');
		Route::get('todo/complete-todo/{id}', 'TodosController@complete')->name('todo.complete');
		Route::get('todo/revert/{id}', 'TodosController@revert')->name('todo.revert');
	} );
	
