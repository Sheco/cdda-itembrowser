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
    $items = Items::search($search);
    return View::make('items.search', compact('items', 'search'));
  }

  public function view($id)
  {
    $item = Items::get($id);
    return View::make('items.view', compact('item'));
  }

  public function craft($id)
  {
    $item = Items::get($id);
    return View::make('items.craft', compact('item'));
  }

  public function recipes($id, $category="")
  {
    $item = Items::get($id);
    $recipes = $item->getToolForCategory($category);
    return View::make('items.recipes', compact('item', "category", "recipes"));
  }
}
