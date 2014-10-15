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

  public function armor($part)
  {
    $items = $this->repo->allObjects("Item", "armor.$part");
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
    $items = $this->repo->allObjects("Item", "gun.$skill");
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
    $items = $this->repo->allObjects("Item", "book.$type");
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
    $items = $this->repo->allObjects("Item", "melee");
    return View::make('items.melee', compact('items'));
  }

  public function comestibles($type="drink")
  {
    $items = $this->repo->allObjects("Item", "comestible.$type");
    $types = array(
      "drink"=>"Drinks",
      "food"=>"Food",
      "med"=>"Meds",
    );
    return View::make('items.comestibles', compact('items','type', 'types'));
  }

  public function qualities($id=null)
  {
    $qualities = $this->repo->allObjects("Quality", "qualities");
    $items = $id? $this->repo->allObjects("Item", "quality.$id"): array();
    return View::make('items.qualities', compact('items', 'qualities', 'id'));
  }

  public function materials($id=null)
  {
    $materials = $this->repo->allObjects("Material", "materials");
    $items = $id? $this->repo->allObjects("Item", "material.$id"): array();
    return View::make('items.materials', compact('items', 'materials', 'id'));
  }

  public function flags($id=null)
  {
    $flags = $this->repo->all("flags");
    sort($flags);
    $items = $id? $this->repo->allObjects("Item", "flag.$id"): array();
    return View::make("items.flags", compact("items", "flags", "id"));
  }

  public function skills($id=null, $level=1) {
    $skills = $this->repo->all("skills");
    sort($skills);
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
