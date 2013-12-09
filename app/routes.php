<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::group(array('after'=>'theme:layouts.bootstrap'), function()
{
  Route::get('/', 'ItemsController@index');

  Route::get('/search', 'ItemsController@search');

  Route::get('/craft/{id}', 'ItemsController@craft')
    ->where('id', '[a-z0-9_]+');

  Route::get('/recipes/{id}', 'ItemsController@recipes')
    ->where('id', '[a-z0-9_]+');

  Route::get('/{id}', "ItemsController@view")
    ->where('id', '[a-z0-9_]+');
});
