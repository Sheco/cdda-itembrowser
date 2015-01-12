<?php

class HomeController extends BaseController 
{
    protected $repo;

    public function __construct(Repositories\RepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function index()
    {
        $version = $this->repo->version();

        $this->layout->nest('content', "index", compact('version'));
    }


    public function sitemap()
    {
        $armorParts = $this->repo->raw("armorParts");
        $gunSkills = $this->repo->raw("gunSkills");
        $bookTypes = $this->repo->raw("bookTypes");
        $qualities = $this->repo->raw("qualities");
        $materials = $this->repo->raw("materials");
        $flags = $this->repo->raw("flags");
        $skills = $this->repo->raw("skills");
        $consumables = $this->repo->raw("consumables");

        $items = $this->repo->allModels("Item");

        $this->layout = View::make('sitemap', compact('items',
            'armorParts', 'gunSkills', 'bookTypes', 'qualities',
            'materials', 'flags', 'skills', 'consumables'));
    }
}
