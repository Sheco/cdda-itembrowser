<?php

class ItemsController extends BaseController
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

        $this->layout->nest('content', "items.index", compact('version'));
    }

    public function search()
    {
        $search = Input::get('q');
        $items = $this->repo->searchObjects("Item", $search);

        $this->layout->nest('content', 'items.search', compact('items', 'search'));
    }

    public function view($id)
    {
        $item = $this->repo->getObjectOrFail("Item", $id);

        $this->layout->nest('content', 'items.view', compact('item'));
    }

    public function craft($id)
    {
        $item = $this->repo->getObjectOrFail("Item", $id);

        $this->layout->nest('content', 'items.craft', compact('item'));
    }

    public function recipes($id, $category = null)
    {
        $item = $this->repo->getObjectOrFail("Item", $id);
        $categories = $item->toolCategories;

        if ($category === null) {
            $category = key($categories);

            return Redirect::route(Route::currentRouteName(), array($id, $category));
        }

        $recipes = $item->getToolForCategory($category);

        usort($recipes, function ($a, $b) {
      return $a->difficulty-$b->difficulty;
    });

        $this->layout->nest('content', 'items.recipes', compact('item', "category", "recipes", "categories"));
    }

    public function disassemble($id)
    {
        $item = $this->repo->getObjectOrFail("Item", $id);

        $this->layout->nest('content', 'items.disassemble', compact('item'));
    }

    public function armors($part = null)
    {
        $parts = array(
      "head" => "Head",
      "eyes" => "Eyes",
      "mouth" => "Mouth",
      "torso" => "Torso",
      "arms" => "Arms",
      "hands" => "Hands",
      "legs" => "Legs",
      "feet" => "Feet",
      "none" => "None",
    );

        if ($part === null) {
            return Redirect::route(Route::currentRouteName(), array(key($parts)));
        }

        $items = $this->repo->allObjects("Item", "armor.$part");

        $this->layout->nest('content', 'items.armor', compact('items', 'parts', 'part'));
    }

    public function guns($skill = null)
    {
        $skills = array(
      "archery" => "Archery",
      "launcher" => "Launchers",
      "pistol" => "Pistols",
      "rifle" => "Rifles",
      "shotgun" => "Shotguns",
      "smg" => "SMGs",
      "throw" => "Thrown",
    );

        if ($skill === null) {
            return Redirect::route(Route::currentRouteName(), array(key($skills)));
        }

        $items = $this->repo->allObjects("Item", "gun.$skill");

        $this->layout->nest('content', 'items.gun', compact('items', 'skills', 'skill'));
    }

    public function books($type = null)
    {
        $types = array(
      "fun" => "Just for fun",
      "range" => "Ranged",
      "combat" => "Combat",
      "engineering" => "Engineering",
      "crafts" => "Crafts",
      "social" => "Social",
      "survival" => "Survival",
      "other" => "Other",
    );

        if ($type === null) {
            return Redirect::route(Route::currentRouteName(), array("combat"));
        }

        $items = $this->repo->allObjects("Item", "book.$type");

        $this->layout->nest('content', 'items.books', compact('items', 'type', 'types'));
    }

    public function melee()
    {
        $items = $this->repo->allObjects("Item", "melee");

        $this->layout->nest('content', "items.melee", compact('items'));
    }

    public function consumables($type = null)
    {
        $types = array(
      "drink" => "Drinks",
      "food" => "Food",
      "med" => "Meds",
    );

        if ($type === null) {
            return Redirect::route(Route::currentRouteName(), array(key($types)));
        }

        $items = $this->repo->allObjects("Item", "consumables.$type");

        $this->layout->nest('content', 'items.consumables', compact('items', 'type', 'types'));
    }

    public function qualities($id = null)
    {
        $qualities = $this->repo->allObjects("Quality", "qualities");

        if ($id === null) {
            return Redirect::route("item.qualities", array(reset($qualities)->id));
        }

        $items = $id ? $this->repo->allObjects("Item", "quality.$id") : array();

        $this->layout->nest('content', 'items.qualities', compact('items', 'qualities', 'id'));
    }

    public function materials($id = null)
    {
        $materials = $this->repo->allObjects("Material", "materials");

        if ($id === null) {
            return Redirect::route(Route::currentRouteName(), array(reset($materials)->ident));
        }
        $items = $id ? $this->repo->allObjects("Item", "material.$id") : array();

        $this->layout->nest('content', 'items.materials', compact('items', 'materials', 'id'));
    }

    public function flags($id = null)
    {
        $flags = $this->repo->all("flags");
        sort($flags);

        if ($id === null) {
            return Redirect::route(Route::currentRouteName(), array(reset($flags)));
        }
        $items = $id ? $this->repo->allObjects("Item", "flag.$id") : array();

        $this->layout->nest('content', "items.flags", compact("items", "flags", "id"));
    }

    public function skills($id = null, $level = 1)
    {
        $skills = $this->repo->all("skills");
        sort($skills);

        if ($id === null) {
            return Redirect::route(Route::currentRouteName(), array(reset($skills), 1));
        }
        $items = $id ? $this->repo->allObjects("Item", "skill.$id.$level") : array();
        $levels = range(1,10);

        $this->layout->nest('content', "items.skills", compact("items", "skills", "id", "level", "levels"));
    }

    public function gunmods($skill = null, $part = null)
    {
        $skills = $this->repo->all("gunmodSkills");
        $parts = $this->repo->all("gunmodParts");
        $mods = $this->repo->allObjects("Item", "gunmods.$skill.$part");

        $this->layout->nest('content', "items.gunmods", compact('skill', 'part', "skills", "parts", 'mods'));
    }

    public function wiki($id)
    {
        $item = $this->repo->getObjectOrFail("Item", $id);

        return Redirect::to("http://www.wiki.cataclysmdda.com/index.php?title=$item->slug");
    }

    public function sitemap()
    {
        $items = $this->repo->allObjects("Item");

        $this->layout->nest('content', 'items.sitemap', compact('items'));
    }
}
