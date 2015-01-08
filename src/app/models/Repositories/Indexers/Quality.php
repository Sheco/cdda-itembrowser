<?php
namespace Repositories\Indexers;

use Repositories\LocalRepository;

class Quality implements IndexerInterface
{
    protected $database;

    const DEFAULT_INDEX = "qualities";
    const ID_FIELD = "id";

    public function onNewObject(LocalRepository $repo, $object)
    {
        if ($object->type == "tool_quality") {
            $repo->append(self::DEFAULT_INDEX, $object->id);
            $repo->set(self::DEFAULT_INDEX.".".$object->id, $object->repo_id);
        }
    }

    public function onFinishedLoading(LocalRepository $repo)
    {
    }
}
