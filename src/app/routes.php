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

Route::group(array('after' => 'theme:layouts.bootstrap'), function () {
  Route::get('/', 'HomeController@index');

  Route::get('/armor/{part?}', function ($part = "") {
    return Redirect::route('item.armors', array($part), 301);
  });

  Route::get('/armors/{part?}', array(
      'as' => 'item.armors',
      'uses' => 'ItemsController@armors', )
  );

  Route::get('/gun/{skill?}', function ($skill = "") {
    return Redirect::route('item.guns', array($skill), 301);
  });

  Route::get('/guns/{skill?}', array(
      'as' => 'item.guns',
      'uses' => 'ItemsController@guns', )
  );

  Route::get('/melee', array(
      'as' => 'item.melee',
      'uses' => 'ItemsController@melee', )
  );

  Route::get('/books/{type?}', array(
      'as' => 'item.books',
      'uses' => 'ItemsController@books', )
  );

  Route::get('/qualities/{id?}', array(
      'as' => 'item.qualities',
      'uses' => 'ItemsController@qualities', )
  );

  Route::get('/materials/{id?}', array(
      'as' => 'item.materials',
      'uses' => 'ItemsController@materials', )
  );

  Route::get('/flags/{id?}', array(
      'as' => 'item.flags',
      'uses' => 'ItemsController@flags', )
  );

  Route::get('/skills/{id?}/{level?}', array(
      'as' => 'item.skills',
      'uses' => 'ItemsController@skills', )
  );

  Route::get('/containers', array(
      'as' => 'item.containers',
      'uses' => 'ItemsController@containers', )
  );

  Route::get('consumables/{type?}', array(
      'as' => 'item.consumables',
      'uses' => 'ItemsController@consumables', )
  );

  Route::get('consumibles/{type?}', function ($type = "") {
    return Redirect::route('item.consumables', array($type), 301);
  });

  Route::get('/search', array(
      'as' => 'search',
      'before'=>'throttle:30,30',
      'uses' => 'HomeController@search', )
  );

  View::composer('layouts.bootstrap', function ($view) {
    $view->with('q', Input::get('q', ''));
    $view->with('sites', Config::get('cataclysm.sites'));
  });

  View::composer('items.menu', function ($view) {
    $view->with('areas', array(
      "view" => array(
        "route" => "item.view",
        "label" => "View item",
      ),
      "craft" => array(
        "route" => "item.craft",
        "label" => "Craft",
      ),
      "recipes" => array(
        "route" => "item.recipes",
        "label" => "Recipes",
      ),
      "disassemble" => array(
        "route" => "item.disassemble",
        "label" => "Disassemble",
      ),
      'construction' => array(
        'route' => 'item.construction',
        'label' => 'Construction'
      ),
      "wiki" => array(
        "route" => "item.wiki",
        "label" => "Wiki",
      ),
    ));
  });

  Route::get('/{id}/craft', array(
      'as' => 'item.craft',
      'uses' => 'ItemsController@craft', )
  )
    ->where('id', '[A-Za-z0-9_-]+');

  Route::get('/{id}/recipes/{category?}', array(
      'as' => 'item.recipes',
      'uses' => 'ItemsController@recipes', )
  )
    ->where('id', '[A-Za-z0-9_-]+')
    ->where('category', '[A-Z_]+');

  Route::get('/{id}', array(
        'as' => 'item.view',
        'uses' => "ItemsController@view", )
  )
    ->where('id', '[A-Za-z0-9_-]+');

  Route::get('/{id}/disassemble', array(
      'as' => 'item.disassemble',
      'uses' => 'ItemsController@disassemble', )
  )
    ->where('id', '[A-Za-z0-9_-]+');

  Route::get('/{id}/construction', array(
      'as'=>'item.construction',
      'uses'=>'ItemsController@construction',
  ))
  ->where('id', '[A-Za-z0-9_-]+');

  Route::get("/construction/view/{id}", array(
      "as"=>"construction.view",
      "uses"=>"WorldController@construction"
  ));

  Route::get('/construction/categories/{id?}', array(
      'as'=>'construction.categories',
      'uses'=>'WorldController@constructionCategories'
  ));

  Route::get('/{id}/wiki', array(
      'as' => 'item.wiki',
      'uses' => 'ItemsController@wiki', )
  )
    ->where('id', '[A-Za-z0-9_-]+');

  Route::get('/monsters/groups/{id?}', array(
    'as' => 'monster.groups',
    'uses' => 'MonsterController@groups', )
  );

  Route::get('/monsters/species/{id?}', array(
    'as' => 'monster.species',
    'uses' => 'MonsterController@species', )
  );

  Route::get('/monsters/{id}', array(
    'as' => 'monster.view',
    'uses' => 'MonsterController@view', )
  );

  Route::get('/gunmods/{skill?}/{part?}', array(
    'as' => 'item.gunmods',
    'uses' => 'ItemsController@gunmods', )
  );
});

Route::get('/sitemap.xml', array(
    'before'=>'throttle:5,60',
    'uses'=>'HomeController@sitemap'
));

