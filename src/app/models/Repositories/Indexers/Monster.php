<?php
namespace Repositories\Indexers;

use Repositories\LocalRepository;

class Monster implements IndexerInterface
{
    protected $database;

    const DEFAULT_INDEX = "monsters";

    public function onNewObject(LocalRepository $repo, $object)
    {
        if ($object->type == "MONSTER") {
            $repo->append(self::DEFAULT_INDEX, $object->id);
            $repo->set(self::DEFAULT_INDEX.".".$object->id, $object->repo_id);
            $objspecies = (array) $object->species;
            foreach ($objspecies as $species) {
                $repo->append("monster.species.$species", $object->id);
                $allSpecies = $repo->raw("monster.species", array());
                $allSpecies[$species] = $species;
                $repo->set("monster.species", $allSpecies);
            }

            return;
        }
    }

    public function onFinishedLoading(LocalRepository $repo)
    {
        $allSpecies = $repo->raw("monster.species");
        sort($allSpecies);
        $repo->set("monster.species", $allSpecies);
    }
}
