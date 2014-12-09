<?php

class MonsterController extends Controller {
  protected $repo;

  public function __construct(Repositories\RepositoryInterface $repo) 
  {
    $this->repo = $repo;
  }

  function groups($id=null)
  {
    $groups = $this->repo->allObjects('MonsterGroup', 'monstergroups');
    if($id===null) {
      $id = reset($groups)->name;
      return Redirect::route("monster.groups", array($id));
    }
    $group = $this->repo->getObject('MonsterGroup', $id);
    return View::make('monsters.groups', compact('groups', 'group', 'id'));
  }

  function species($id=null)
  {
    $species = $this->repo->all("monster.species");
    usort($species, function($a, $b) {
      return strcmp($a, $b); 
    });
    if($id===null) {
      $id = reset($groups)->name;
      return Redirect::route("monster.species", array($id));
    }
    $data = $this->repo->allObjects("Monster", "monster.species.$id");
    usort($data, function($a, $b) {
      return strcmp(strtolower($a->name), strtolower($b->name));
    });
    return View::make('monsters.species', compact('species', 'id', 'data'));
    
  }

  function view($id)
  {
    $monster = $this->repo->getObject('Monster', $id);
    return View::make('monsters.view', compact('id', 'monster'));
  }
}

