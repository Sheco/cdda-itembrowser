<?php
namespace Repositories\Indexers;

use Repositories\LocalRepository;

class MonsterGroup implements IndexerInterface
{
    protected $database;

    const DEFAULT_INDEX = "monstergroups";
    const ID_FIELD = "name";

    public function onFinishedLoading(LocalRepository $repo)
    {
        foreach ($repo->all(self::DEFAULT_INDEX) as $id) {
            $group = $repo->get(self::DEFAULT_INDEX, $id);
        }
    }

    public function onNewObject(LocalRepository $repo, $object)
    {
        if ($object->type == "monstergroup") {
            $repo->set(self::DEFAULT_INDEX, $object->name);
            $repo->set(self::DEFAULT_INDEX.".".$object->name, $object->repo_id);

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
}
