<?php

class ItemsController extends Controller 
{
  protected $item;
  protected $repo;
  protected $quality;

  public function __construct(
    Repositories\Item $item,
    Repositories\Quality $quality,
    Repositories\Repository $repo
  ) 
  {
    $this->item = $item;
    $this->quality = $quality;
    $this->repo = $repo;
  }

  public function index()
  {
    $version = $this->repo->version();
    return View::make('items.index', compact('version'));
  }

  public function search()
  {
    $search = Input::get('q');
    $items = $this->item->where($search);
    return View::make('items.search', compact('items', 'search'));
  }

  public function view($id)
  {
    $item = $this->item->getOrFail($id);
    return View::make('items.view', compact('item'));
  }

  public function craft($id)
  {
    $item = $this->item->getOrFail($id);
    return View::make('items.craft', compact('item'));
  }

  public function recipes($id, $category="")
  {
    $item = $this->item->getOrFail($id);
    $categories = $item->toolCategories;
    if ($category=="" && $categories) 
      return Redirect::route("item.recipes", array($id, key($categories)));

    $recipes = $item->getToolForCategory($category);

    return View::make('items.recipes', compact('item', "category", "recipes", "categories"));
  }

  public function disassemble($id)
  {
    $item = $this->item->getOrFail($id);
    return View::make('items.disassemble', compact('item'));
  }

  public function armor($part)
  {
    $items = $this->item->all("armor.$part");
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
    $items = $this->item->all("gun.$skill");
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
    $items = $this->item->all("book.$type");
    $types = array(
      "fun"=>"Just for fun",
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
    $items = $this->item->all("melee");
    return View::make('items.melee', compact('items'));
  }

  public function comestibles($type="drink")
  {
    $items = $this->item->all("comestible.$type");
    $types = array(
      "drink"=>"Drinks",
      "food"=>"Food",
      "med"=>"Meds",
    );
    return View::make('items.comestibles', compact('items','type', 'types'));
  }

  public function qualities($id=null)
  {
    $qualities = $this->quality->all("qualities");
    $items = $id? $this->item->all("quality.$id"): array();
    return View::make('items.qualities', compact('items', 'qualities', 'id'));
  }

  public function sitemap()
  {
    $items = $this->item->all();
    return View::make('items.sitemap', compact('items'));
  }
}
