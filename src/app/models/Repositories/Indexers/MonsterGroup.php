<?php
namespace Repositories\Indexers;

class MonsterGroup
{
  protected $database;

  const DEFAULT_INDEX = "monstergroups";
  const ID_FIELD = "name";

  public function __construct()
  {
    \Event::listen("cataclysm.newObject", function ($repo, $object) {
      $this->getIndexes($repo, $object);
    });

    \Event::listen("cataclysm.finishedLoading", function($repo)
    {
      $this->finishLoading($repo);
    });
  }

  private function finishLoading($repo) {
    foreach($repo->all(self::DEFAULT_INDEX) as $id) {
      $group = $repo->get(self::DEFAULT_INDEX, $id);
    }
  }

  private function getIndexes($repo, &$object)
  {
    if ($object->type=="monstergroup") {
      $repo->addIndex(self::DEFAULT_INDEX, $object->name, $object->repo_id);

      // create unique monsters array
      $monsters = array();
      foreach($object->monsters as $monster) {
        $monster = $monster->monster;
        $monsters[$monster] = true;
      }
      $object->uniqueMonsters = array_keys($monsters);
      return;
    }
  }

  public function model()
  {
    return \App::make("MonsterGroup");
  }
}

