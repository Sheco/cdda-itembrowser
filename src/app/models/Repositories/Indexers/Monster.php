<?php
namespace Repositories\Indexers;

class Monster
{
  protected $database;

  const DEFAULT_INDEX = "monsters";
  const ID_FIELD = "id";

  public function __construct()
  {
    \Event::listen("cataclysm.newObject", function ($repo, $object) {
      $this->getIndexes($repo, $object);
    });
  }

  private function getIndexes($repo, &$object)
  {
    if ($object->type=="MONSTER") {
      $repo->addIndex(self::DEFAULT_INDEX, $object->id, $object->repo_id);
      $object->species = (array) $object->species;
      foreach($object->species as $species) {
        $repo->addIndex("monster.species.$species", $object->id, $object->repo_id);
        $repo->addIndex("monster.species", $species, $species);
      }
      return;
    }
  }

  public function model()
  {
    return \App::make("Monster");
  }
}

