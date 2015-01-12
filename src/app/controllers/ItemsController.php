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
        $items = $this->repo->searchModels("Item", $search);

        $this->layout->nest('content', 'items.search', compact('items', 'search'));
    }

    public function view($id)
    {
        $item = $this->repo->getModelOrFail("Item", $id);

        $this->layout->nest('content', 'items.view', compact('item'));
    }

    public function craft($id)
    {
        $item = $this->repo->getModelOrFail("Item", $id);

        $this->layout->nest('content', 'items.craft', compact('item'));
    }

    public function recipes($id, $category = null)
    {
        $item = $this->repo->getModelOrFail("Item", $id);
        $categories = $item->toolCategories;

        if ($category === null) {
            $category = key($categories);

            return Redirect::route(Route::currentRouteName(), array($id, $category));
        }

        $recipes = $item->getToolForCategory($category);

        $this->layout->nest('content', 'items.recipes', compact('item', "category", "recipes", "categories"));
    }

    public function disassemble($id)
    {
        $item = $this->repo->getModelOrFail("Item", $id);

        $this->layout->nest('content', 'items.disassemble', compact('item'));
    }

    public function armors($part = null)
    {
        $parts = $this->repo->raw("armorParts"); 

        if ($part === null) {
            return Redirect::route(Route::currentRouteName(), array(reset($parts)));
        }

        $items = $this->repo->allModels("Item", "armor.$part");

        $this->layout->nest('content', 'items.armor', compact('items', 'parts', 'part'));
    }

    public function guns($skill = null)
    {
        $skills = $this->repo->raw("gunSkills");

        if ($skill === null) {
            return Redirect::route(Route::currentRouteName(), array(reset($skills)));
        }

        $items = $this->repo->allModels("Item", "gun.$skill");

        $this->layout->nest('content', 'items.gun', compact('items', 'skills', 'skill'));
    }

    public function books($type = null)
    {
        $types = $this->repo->raw("bookSkills"); 

        if ($type === null) {
            return Redirect::route(Route::currentRouteName(), reset($types));
        }

        $items = $this->repo->allModels("Item", "book.$type");

        $this->layout->nest('content', 'items.books', compact('items', 'type', 'types'));
    }

    public function melee()
    {
        $items = $this->repo->allModels("Item", "melee");

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

        $items = $this->repo->allModels("Item", "consumables.$type");

        $this->layout->nest('content', 'items.consumables', compact('items', 'type', 'types'));
    }

    public function qualities($id = null)
    {
        $qualities = $this->repo->allModels("Quality", "qualities");

        if ($id === null) {
            return Redirect::route("item.qualities", array(reset($qualities)->id));
        }
        
        $items = $this->repo->allModels("Item", "quality.$id");

        $this->layout->nest('content', 'items.qualities', compact('items', 'qualities', 'id'));
    }

    public function materials($id = null)
    {
        $materials = $this->repo->allModels("Material", "materials");

        if ($id === null) {
            return Redirect::route(Route::currentRouteName(), array(reset($materials)->ident));
        }
        $items = $this->repo->allModels("Item", "material.$id");

        $this->layout->nest('content', 'items.materials', compact('items', 'materials', 'id'));
    }

    public function flags($id = null)
    {
        $flags = $this->repo->raw("flags");

        if ($id === null) {
            return Redirect::route(Route::currentRouteName(), array(reset($flags)));
        }
        $items = $this->repo->allModels("Item", "flag.$id");

        $this->layout->nest('content', "items.flags", compact("items", "flags", "id"));
    }

    public function skills($id = null, $level = 1)
    {
        $skills = $this->repo->raw("skills");

        if ($id === null) {
            return Redirect::route(Route::currentRouteName(), array(reset($skills), 1));
        }
        $items = $this->repo->allModels("Item", "skill.$id.$level");
        $levels = range(1, 10);

        $this->layout->nest('content', "items.skills", compact("items", "skills", "id", "level", "levels"));
    }

    public function gunmods($skill = null, $part = null)
    {
        $skills = $this->repo->raw("gunmodSkills");
        $parts = $this->repo->raw("gunmodParts");
        $mods = $this->repo->allModels("Item", "gunmods.$skill.$part");

        $this->layout->nest('content', "items.gunmods", compact('skill', 'part', "skills", "parts", 'mods'));
    }

    public function wiki($id)
    {
        $item = $this->repo->getModelOrFail("Item", $id);

        return Redirect::to("http://www.wiki.cataclysmdda.com/index.php?title=$item->slug");
    }

    public function sitemap()
    {
        $items = $this->repo->allModels("Item");

        $this->layout->nest('content', 'items.sitemap', compact('items'));
    }
}
