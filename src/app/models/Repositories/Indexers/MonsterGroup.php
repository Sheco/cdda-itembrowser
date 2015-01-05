<?php
namespace Repositories\Indexers;

class MonsterGroup implements IndexerInterface
{
    protected $database;

    const DEFAULT_INDEX = "monstergroups";
    const ID_FIELD = "name";

    public function finishedLoading($repo)
    {
        foreach ($repo->all(self::DEFAULT_INDEX) as $id) {
            $group = $repo->get(self::DEFAULT_INDEX, $id);
        }
    }

    public function getIndexes($repo, $object)
    {
        if ($object->type == "monstergroup") {
            $repo->addIndex(self::DEFAULT_INDEX, $object->name, $object->repo_id);

            // create unique monsters array
            $monsters = array();

            foreach ($object->monsters as $monster) {
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
