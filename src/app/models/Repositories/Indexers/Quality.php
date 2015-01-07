<?php
namespace Repositories\Indexers;

use Repositories\LocalRepository;

class Quality implements IndexerInterface
{
    protected $database;

    const DEFAULT_INDEX = "tool_quality";
    const ID_FIELD = "id";

    public function onNewObject(LocalRepository $repo, $object)
    {
        if ($object->type == "tool_quality") {
            $repo->addIndex(self::DEFAULT_INDEX, $object->id, $object->repo_id);
        }
    }

    public function onFinishedLoading(LocalRepository $repo)
    {
    }
}
