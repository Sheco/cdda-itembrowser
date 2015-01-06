<?php
namespace Repositories\Indexers;

class Material implements IndexerInterface
{
    protected $database;

    const DEFAULT_INDEX = "materials";
    const ID_FIELD = "ident";

    public function onNewObject($repo, $object)
    {
        if ($object->type == "material") {
            $repo->addIndex(self::DEFAULT_INDEX, $object->ident, $object->repo_id);
        }
    }

    public function onFinishedLoading($repo)
    {
    }

    public function model()
    {
        return \App::make("Material");
    }
}
