<?php
namespace Repositories\Indexers;

use Repositories\RepositoryWriterInterface;

class Quality implements IndexerInterface
{
    protected $database;

    const DEFAULT_INDEX = "qualities";

    public function onNewObject(RepositoryWriterInterface $repo, $object)
    {
        if ($object->type == "tool_quality") {
            $repo->append(self::DEFAULT_INDEX, $object->id);
            $repo->set(self::DEFAULT_INDEX.".".$object->id, $object->repo_id);
        }
    }

    public function onFinishedLoading(RepositoryWriterInterface $repo)
    {
    }
}
