<?php

class MonsterController extends BaseController
{
    protected $repo;

    public function __construct(Repositories\RepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function groups($id = null)
    {
        $groups = $this->repo->allModels('MonsterGroup', 'monstergroups');
        if ($id === null) {
            $id = reset($groups)->name;

            return Redirect::route("monster.groups", array($id));
        }
        $group = $this->repo->getModel('MonsterGroup', $id);
        $data = $group->uniqueMonsters;

        $this->layout->nest('content', 'monsters.groups', compact('groups', 'group', 'id', 'data'));
    }

    public function species($id = null)
    {
        $species = $this->repo->all("monster.species");
        if ($id === null) {
            $id = reset($species);

            return Redirect::route("monster.species", array($id));
        }
        $data = $this->repo->allModels("Monster", "monster.species.$id");

        $this->layout->nest('content', 'monsters.species', compact('species', 'id', 'data'));
    }

    public function view($id)
    {
        $monster = $this->repo->getModel('Monster', $id);

        $this->layout->nest('content', 'monsters.view', compact('id', 'monster'));
    }
}
