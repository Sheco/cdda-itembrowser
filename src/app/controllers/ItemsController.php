<?php

class ItemsController extends Controller 
{
  protected $item;

  public function __construct(Repositories\Item $item) 
  {
    $this->item = $item;
  }

  public function index()
  {
    return View::make('items.index');
  }

  public function search()
  {
    $search = Input::get('q');
    $items = $this->item->where($search);
    return View::make('items.search', compact('items', 'search'));
  }

  public function view($id)
  {
    $item = $this->item->findOr404($id);
    return View::make('items.view', compact('item'));
  }

  public function craft($id)
  {
    $item = $this->item->findOr404($id);
    return View::make('items.craft', compact('item'));
  }

  public function recipes($id, $category="")
  {
    $item = $this->item->findOr404($id);
    $categories = $item->toolCategories;
    if ($category=="" && $categories) 
      return Redirect::route("item.recipes", array($id, $categories[0]));

    $recipes = $item->getToolForCategory($category);

    return View::make('items.recipes', compact('item', "category", "recipes", "categories"));
  }

  public function disassemble($id)
  {
    $item = $this->item->findOr404($id);
    return View::make('items.disassemble', compact('item'));
  }

  public function armor($part)
  {
    $items = $this->item->index("armor.$part");
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

  public function gun($skill)
  {
    $items = $this->item->index("gun.$skill");
    $skills = array(
      "archery"=>"Archery",
      "launcher"=>"Launchers",
      "pistol"=>"Pistols",
      "rifle"=>"Rifles",
      "shotgun"=>"Shotguns",
      "smg"=>"SMGs",
      "throw" =>"Thrown",
    );
    return View::make('items.gun', compact('items','skills','skill'));
  }

  public function books($type="combat")
  {
    $items = $this->item->index("book.$type");
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
    $items = $this->item->index("melee");
    return View::make('items.melee', compact('items'));
  }

  public function sitemap()
  {
    $items = $this->item->all();
    return View::make('items.sitemap', compact('items'));
  }
}
