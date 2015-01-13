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
        $sitemap = Cache::rememberForever('sitemap', function() {
            $armorParts = $this->repo->raw("armorParts");
            $gunSkills = $this->repo->raw("gunSkills");
            $bookTypes = $this->repo->raw("bookTypes");
            $qualities = $this->repo->raw("qualities");
            $materials = $this->repo->raw("materials");
            $flags = $this->repo->raw("flags");
            $skills = $this->repo->raw("skills");
            $consumables = $this->repo->raw("consumables");
            $monsterGroups = $this->repo->allModels("MonsterGroup", "monstergroups");
            $monsterSpecies = $this->repo->raw("monster.species");
            $monsters = $this->repo->allModels("Monster", "monsters");

            $items = $this->repo->allModels("Item");

            return gzcompress((string) View::make('sitemap', compact('items',
                'armorParts', 'gunSkills', 'bookTypes', 'qualities',
                'materials', 'flags', 'skills', 'consumables',
                'monsterGroups', 'monsterSpecies', 'monsters')));
        });
        $this->layout = gzuncompress($sitemap);
    }
}
