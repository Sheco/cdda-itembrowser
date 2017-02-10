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

                // skip objects without an ID    
                if(!isset($object->id)) return;

                $repo->append(self::DEFAULT_INDEX, $object->id);
                $repo->set(self::DEFAULT_INDEX.".".$object->id, $object->repo_id);

                // define a default "none" species
                if(!isset($object->species))  $object->species = "none";

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
