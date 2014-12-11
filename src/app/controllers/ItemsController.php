<?php

class ItemsController extends Controller 
{
  protected $item;
  protected $repo;

  public function __construct(Repositories\RepositoryInterface $repo) 
  {
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
    $items = $this->repo->searchObjects("Item", $search);
    return View::make('items.search', compact('items', 'search'));
  }

  public function view($id)
  {
    $item = $this->repo->getObjectOrFail("Item", $id);
    return View::make('items.view', compact('item'));
  }

  public function craft($id)
  {
    $item = $this->repo->getObjectOrFail("Item", $id);
    return View::make('items.craft', compact('item'));
  }

  public function recipesProxy($id)
  {
    $item = $this->repo->getObjectOrFail("Item", $id);
    $categories = $item->toolCategories;
    $category = key($categories)?: "CC_NONE";
    
    return Redirect::route("item.recipes", array($id, $category));
  }

  public function recipes($id, $category)
  {
    $item = $this->repo->getObjectOrFail("Item", $id);
    $categories = $item->toolCategories;
    $recipes = $item->getToolForCategory($category);

    usort($recipes, function($a, $b) {
      return $a->difficulty-$b->difficulty;
    });

    return View::make('items.recipes', compact('item', "category", "recipes", "categories"));
  }

  public function disassemble($id)
  {
    $item = $this->repo->getObjectOrFail("Item", $id);
    return View::make('items.disassemble', compact('item'));
  }

  public function armor($part=null)
  {
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

    if($part===null) {
      return Redirect::route(Route::currentRouteName(), array(key($parts)));
    }

    $items = $this->repo->allObjects("Item", "armor.$part");
    return View::make('items.armor', compact('items','parts','part'));
  }

  public function gun($skill=null)
  {
    $skills = array(
      "archery"=>"Archery",
      "launcher"=>"Launchers",
      "pistol"=>"Pistols",
      "rifle"=>"Rifles",
      "shotgun"=>"Shotguns",
      "smg"=>"SMGs",
      "throw" =>"Thrown",
    );

    if($skill===null) {
      return Redirect::route(Route::currentRouteName(), array(key($skills)));
    }

    $items = $this->repo->allObjects("Item", "gun.$skill");
    return View::make('items.gun', compact('items','skills','skill'));
  }

  public function books($type=null)
  {
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

    if($type===null) {
      return Redirect::route(Route::currentRouteName(), array("combat"));
    }

    $items = $this->repo->allObjects("Item", "book.$type");
    return View::make('items.books', compact('items','type', 'types'));
  }

  public function melee()
  {
    $items = $this->repo->allObjects("Item", "melee");
    return View::make(Route::currentRouteName(), compact('items'));
  }

  public function consumables($type=null)
  {
    $types = array(
      "drink"=>"Drinks",
      "food"=>"Food",
      "med"=>"Meds",
    );

    if($type===null) {
      return Redirect::route(Route::currentRouteName(), array(key($types)));
    }

    $items = $this->repo->allObjects("Item", "consumables.$type");
    return View::make('items.consumables', compact('items','type', 'types'));
  }

  public function qualities($id=null)
  {
    $qualities = $this->repo->allObjects("Quality", "qualities");

    if($id===null) {
      return Redirect::route("item.qualities", array(reset($qualities)->id));
    }

    $items = $id? $this->repo->allObjects("Item", "quality.$id"): array();
    return View::make('items.qualities', compact('items', 'qualities', 'id'));
  }

  public function materials($id=null)
  {
    $materials = $this->repo->allObjects("Material", "materials");

    if($id===null) {
      return Redirect::route(Route::currentRouteName(), array(reset($materials)->ident));
    }
    $items = $id? $this->repo->allObjects("Item", "material.$id"): array();
    return View::make('items.materials', compact('items', 'materials', 'id'));
  }

  public function flags($id=null)
  {
    $flags = $this->repo->all("flags");
    sort($flags);

    if($id===null) {
      return Redirect::route(Route::currentRouteName(), array(reset($flags)));
    }
    $items = $id? $this->repo->allObjects("Item", "flag.$id"): array();
    usort($items, function($a, $b) {
      return strcmp(strtolower($a->name),strtolower($b->name));
    });
    return View::make("items.flags", compact("items", "flags", "id"));
  }

  public function skills($id=null, $level=1) {
    $skills = $this->repo->all("skills");
    sort($skills);

    if($id===null) {
      return Redirect::route(Route::currentRouteName(), array(reset($skills)));
    }
    $items = $id? $this->repo->allObjects("Item", "skill.$id.$level"): array();
    $levels = array(1,2,3,4,5,6,7,8,9,10);
    return View::make("items.skills", compact("items", "skills", "id", "level", "levels"));
  }

  public function wiki($id)
  {
    $item = $this->repo->getObjectOrFail("Item", $id);
    return Redirect::to("http://www.wiki.cataclysmdda.com/index.php?title=$item->slug");
  }

  public function sitemap()
  {
    $items = $this->repo->allObjects("Item");
    return View::make('items.sitemap', compact('items'));
  }
}
