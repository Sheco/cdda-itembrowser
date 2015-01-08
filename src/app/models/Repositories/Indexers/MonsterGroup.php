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
    }

    public function onNewObject(LocalRepository $repo, $object)
    {
        if ($object->type == "monstergroup") {
            $repo->set(self::DEFAULT_INDEX, $object->name);
            $repo->set(self::DEFAULT_INDEX.".".$object->name, $object->repo_id);

            return;
        }
    }
}
