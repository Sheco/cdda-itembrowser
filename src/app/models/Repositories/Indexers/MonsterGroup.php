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
        $groups = $repo->raw(self::DEFAULT_INDEX);
        sort($groups);
        $repo->set(self::DEFAULT_INDEX, $groups);
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
