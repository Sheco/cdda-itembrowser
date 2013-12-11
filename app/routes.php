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

  Route::get('/search', array(
      'as'=>'item.search', 
      'uses'=>'ItemsController@search')
  );

  Route::get('/{id}/craft', array(
      'as'=>'item.craft',
      'uses'=>'ItemsController@craft')
  )
    ->where('id', '[A-Za-z0-9_-]+');

  Route::get('/{id}/recipes/{category?}', array(
      'as'=>'item.recipes',
      'uses'=>'ItemsController@recipes')
  )
    ->where('id', '[A-Za-z0-9_-]+')
    ->where('category', '[A-Z_]+');

  Route::get('/{id}', array(
        'as'=>'item.view',
        'uses'=>"ItemsController@view")
  )
    ->where('id', '[A-Za-z0-9_-]+');
});
