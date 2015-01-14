<?php
namespace Repositories\Indexers;


use Repositories\RepositoryWriterInterface;

class Construction implements IndexerInterface
{
    const DEFAULT_INDEX = "construction";

    public function onNewObject(RepositoryWriterInterface $repo, $object)
    {
        if($object->type!="construction")
            return;

        $repo->append(self::DEFAULT_INDEX, $object->repo_id);
        $repo->set(self::DEFAULT_INDEX.".$object->repo_id", $object->repo_id);

        $repo->append("construction.category.$object->category", $object->repo_id);
        $repo->addUnique("construction.categories", $object->category);

        if(isset($object->components)) foreach($object->components as $group) {
            foreach($group as $component) {
                $item = $component[0];
                $repo->addUnique("construction.$item", $object->repo_id);
            }
        }

        if(isset($object->tools)) foreach($object->tools as $group) {
            foreach($group as $item) {
                if(is_array($item))
                    list($item, $amount) = $item;
                $repo->addUnique("construction.$item", $object->repo_id);
            }
        }
    }

    private function itemQualityLevel($item, $quality)
    {
        foreach($item->qualities as $q) 
            if($q[0] == $quality)
                return $q[1];
    }

    public function onFinishedLoading(RepositoryWriterInterface $repo)
    {
        foreach($repo->raw(self::DEFAULT_INDEX) as $id) {
            $object = $repo->get(self::DEFAULT_INDEX.".$id");

            if(isset($object->qualities)) foreach($object->qualities as $group) {
                foreach($group as $quality) {
                    foreach($repo->raw("quality.$quality->id") as $item_id) {
                        $item = $repo->get("item.$item_id");
                        if($this->itemQualityLevel($item, $quality->id)<$quality->level)
                            continue;
                        $repo->addUnique("construction.$item_id", $id); 
                    }
                }
            }
        }
    }
}
