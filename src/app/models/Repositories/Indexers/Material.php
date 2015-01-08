<?php
namespace Repositories\Indexers;

use Repositories\LocalRepository;

class Material implements IndexerInterface
{
    protected $database;

    const DEFAULT_INDEX = "materials";
    const ID_FIELD = "ident";

    public function onNewObject(LocalRepository $repo, $object)
    {
        if ($object->type == "material") {
            $repo->set(self::DEFAULT_INDEX, $object->ident, $object->repo_id);
            $repo->set(self::DEFAULT_INDEX.".".$object->ident, $object->ident, $object->repo_id);
        }
    }

    public function onFinishedLoading(LocalRepository $repo)
    {
    }
}
