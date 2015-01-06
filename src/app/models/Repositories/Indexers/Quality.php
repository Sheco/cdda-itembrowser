<?php
namespace Repositories\Indexers;

class Quality implements IndexerInterface
{
    protected $database;

    const DEFAULT_INDEX = "tool_quality";
    const ID_FIELD = "id";

    public function onNewObject($repo, $object)
    {
        if ($object->type == "tool_quality") {
            $repo->addIndex(self::DEFAULT_INDEX, $object->id, $object->repo_id);
        }
    }

    public function onFinishedLoading($repo)
    {
    }

    public function model()
    {
        return \App::make("Quality");
    }
}
