<?php
namespace Repositories\Indexers;

use Repositories\RepositoryWriterInterface;

class Terrain implements IndexerInterface
{
    const DEFAULT_INDEX = "terrains";

    public function onNewObject(RepositoryWriterInterface $repo, $object)
    {
        if($object->type!="terrain")
            return;

        $repo->append(self::DEFAULT_INDEX, $object->id);
        $repo->set(self::DEFAULT_INDEX.".$object->id", $object->repo_id);
    }

    public function onFinishedLoading(RepositoryWriterInterface $repo)
    {
    }
}
