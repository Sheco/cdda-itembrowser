<?php
namespace Repositories\Indexers;

use Repositories\RepositoryWriterInterface;

class MonsterGroup implements IndexerInterface
{
    protected $database;

    const DEFAULT_INDEX = "monstergroups";

    public function onFinishedLoading(RepositoryWriterInterface $repo)
    {
        $repo->sort(self::DEFAULT_INDEX);
    }

    public function onNewObject(RepositoryWriterInterface $repo, $object)
    {
        if ($object->type == "monstergroup") {
            $repo->append(self::DEFAULT_INDEX, $object->name);
            $repo->set(self::DEFAULT_INDEX.".".$object->name, $object->repo_id);

            return;
        }
    }
}
