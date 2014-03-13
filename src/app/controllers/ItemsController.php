<?php

class ItemsController extends Controller 
{
  protected $item;
  protected $recipe;
  protected $material;

  public function __construct(
    Repositories\Item $item, 
    Repositories\Recipe $recipe, 
    Repositories\Material $material
  ) {
    $this->item = $item;
    $this->recipe = $recipe;
    $this->material= $material;
  }

  public function index()
  {
    return View::make('items.index');
  }

  public function search()
  {
    $search = Input::get('q');
    if ($search=="")
      return Redirect::to("/");
    $items = $this->item->where($search);
    return View::make('items.search', compact('items', 'search'));
  }

  public function view($id)
  {
    $item = $this->item->find($id);
    if ($item->type=="invalid") App::abort(404);
    $recipeRepository = $this->recipe;
    return View::make('items.view', compact('item', 'recipeRepository'));
  }

  public function craft($id)
  {
    $item = $this->item->find($id);
    if ($item->type=="invalid") App::abort(404);
    $itemRepository = $this->item;
    return View::make('items.craft', compact('item', 'itemRepository'));
  }

  public function recipes($id, $category="")
  {
    $item = $this->item->find($id);
    if ($item->type=="invalid") App::abort(404);
    $categories = $item->toolCategories;
    if ($category=="" && $categories) {
      $category = $categories[0];
    }
    $recipes = $item->getToolForCategory($category);

    return View::make('items.recipes', compact('item', "category", "recipes", "categories"));
  }

  public function disassemble($id)
  {
    $item = $this->item->find($id);
    if ($item->type=="invalid") App::abort(404);
    return View::make('items.disassemble', compact('item'));
  }

  public function armor($part)
  {
    $data = $this->item->index("armor.$part");
    $items = array_map(function ($id, $item) {
      return $this->item->find($item);
    }, $data, array_keys($data));
    $parts = array(
      "head"=>"Head",
      "eyes"=>"Eyes",
      "mouth"=>"Mouth",
      "torso"=>"Torso",
      "arms"=>"Arms",
      "hands"=>"Hands",
      "legs" =>"Legs",
      "feet" =>"Feet",
      "none"=>"None"
    );
    return View::make('items.armor', compact('items','parts','part'));
  }

  public function books($type="combat")
  {
    $data = $this->item->index("book.$type");
    $items = array_map(function ($id, $item) {
      return $this->item->find($item);
    }, $data, array_keys($data));
    $types = array(
      "entertainment"=>"Entertainment",
      "boring"=>"Boring",
      "range"=>"Ranged",
      "combat"=>"Combat",
      "engineering"=>"Engineering",
      "crafts"=>"Crafts",
      "social"=>"Social",
      "survival"=>"Survival",
      "other"=>"Other",
    );
    return View::make('items.books', compact('items','type', 'types'));
  }

  public function melee()
  {
    $data = $this->item->index("melee");
    $items = array_map(function ($id, $item) {
      return $this->item->find($item);
    }, $data, array_keys($data));
    return View::make('items.melee', compact('items'));
  }

  public function sitemap()
  {
    $items = $this->item->all();
    $items = array_map(function ($item, $id) { 
      return $this->item->find($id);
    }, $items, array_keys($items));
    return View::make('items.sitemap', compact('items'));
  }
}
