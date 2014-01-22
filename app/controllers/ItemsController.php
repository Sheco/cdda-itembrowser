<?php

class ItemsController extends BaseController 
{
  public function index()
  {
    return View::make('items.index');
  }

  public function search()
  {
    $search = Input::get('q');
    if($search=="")
      return Redirect::to("/");
    $items = Repositories\Item::search($search);
    return View::make('items.search', compact('items', 'search'));
  }

  public function view($id)
  {
    $item = Repositories\Item::get($id);
    return View::make('items.view', compact('item'));
  }

  public function craft($id)
  {
    $item = Repositories\Item::get($id);
    return View::make('items.craft', compact('item'));
  }

  public function recipes($id, $category="")
  {
    $item = Repositories\Item::get($id);
    $categories = $item->toolCategories;
    if($category=="" && $categories)
    {
      $category = $categories[0];
    }
    $recipes = $item->getToolForCategory($category);

    return View::make('items.recipes', compact('item', "category", "recipes", "categories"));
  }

  public function disassemble($id)
  {
    $item = Repositories\Items::get($id);
    return View::make('items.disassemble', compact('item'));
  }

}
