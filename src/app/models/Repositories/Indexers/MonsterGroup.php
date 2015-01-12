<?php
namespace Repositories\Indexers;

use Repositories\LocalRepository;

class MonsterGroup implements IndexerInterface
{
    protected $database;

    const DEFAULT_INDEX = "monstergroups";

    public function onFinishedLoading(LocalRepository $repo)
    {
        $repo->sort(self::DEFAULT_INDEX);
    }

    public function onNewObject(LocalRepository $repo, $object)
    {
        if ($object->type == "monstergroup") {
            $repo->append(self::DEFAULT_INDEX, $object->name);
            $repo->set(self::DEFAULT_INDEX.".".$object->name, $object->repo_id);

            return;
        }
    }
}
