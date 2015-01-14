<?php
namespace Repositories\Indexers;

use Repositories\RepositoryWriterInterface;

class Furniture implements IndexerInterface
{
    const DEFAULT_INDEX = "furnitures";

    public function onNewObject(RepositoryWriterInterface $repo, $object)
    {
        if($object->type!="furniture")
            return;

        $repo->append(self::DEFAULT_INDEX, $object->id);
        $repo->set(self::DEFAULT_INDEX.".$object->id", $object->repo_id);
        $repo->set("all.$object->id", $object->repo_id);
    }

    public function onFinishedLoading(RepositoryWriterInterface $repo)
    {
    }
}

