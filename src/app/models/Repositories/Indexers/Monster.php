<?php
namespace Repositories\Indexers;

use Repositories\RepositoryWriterInterface;

class Monster implements IndexerInterface
{
    protected $database;

    const DEFAULT_INDEX = "monsters";

    public function onNewObject(RepositoryWriterInterface $repo, $object)
    {
        if ($object->type == "MONSTER") {
            $repo->append(self::DEFAULT_INDEX, $object->id);
            $repo->set(self::DEFAULT_INDEX.".".$object->id, $object->repo_id);
            $objspecies = (array) $object->species;
            foreach ($objspecies as $species) {
                $repo->append("monster.species.$species", $object->id);
                $repo->addUnique("monster.species", $species);
            }

            return;
        }
    }

    public function onFinishedLoading(RepositoryWriterInterface $repo)
    {
        $repo->sort("monster.species");
    }
}
