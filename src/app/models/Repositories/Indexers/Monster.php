<?php
namespace Repositories\Indexers;

class Monster implements IndexerInterface
{
  protected $database;

  const DEFAULT_INDEX = "monsters";
  const ID_FIELD = "id";

  public function getIndexes($repo, $object)
  {
    if ($object->type=="MONSTER") {
      $repo->addIndex(self::DEFAULT_INDEX, $object->id, $object->repo_id);
      $objspecies = (array) $object->species;
      foreach($objspecies as $species) {
        $repo->addIndex("monster.species.$species", $object->id, $object->repo_id);
        $repo->addIndex("monster.species", $species, $species);
      }
      return;
    }
  }

  public function finishedLoading($repo)
  {
  }

  public function model()
  {
    return \App::make("Monster");
  }
}

