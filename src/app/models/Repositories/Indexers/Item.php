<?php
namespace Repositories\Indexers;

use Repositories\LocalRepository;

class Item implements IndexerInterface
{
    protected $types;

    const DEFAULT_INDEX = "item";
    const ID_FIELD = "id";

    public function __construct()
    {
        // this is a hash with the valid item types
        $this->types = array_flip(array(
            "AMMO", "GUN", "ARMOR", "TOOL", "TOOL_ARMOR", "BOOK", "COMESTIBLE",
            "CONTAINER", "GUNMOD", "GENERIC", "BIONIC_ITEM", "VAR_VEH_PART",
            "_SPECIAL",
        ));

        $this->book_types = array(
            "archery" => "range",
            "handguns" => "range",
            "markmanship" => "range",
            "launcher" => "range",
            "firearms" => "range",
            "throw" => "range",
            "rifle" => "range",
            "shotgun" => "range",
            "smg" => "range",
            "pistol" => "range",
            "gun" => "range",
            "bashing" => "combat",
            "cutting" => "combat",
            "stabbing" => "combat",
            "dodge" => "combat",
            "melee" => "combat",
            "unarmed" => "combat",
            "computer" => "engineering",
            "electronics" => "engineering",
            "fabrication" => "engineering",
            "mechanics" => "engineering",
            "construction" => "engineering",
            "carpentry" => "engineering",
            "traps" => "engineering",
            "tailor" => "crafts",
            "firstaid" => "crafts",
            "cooking" => "crafts",
            "barter" => "social",
            "speech" => "social",
            "driving" => "survival",
            "survival" => "survival",
            "swimming" => "survival",
            "none" => "fun",
        );
    }

    public function onFinishedLoading(LocalRepository $repo)
    {
        foreach ($repo->all(self::DEFAULT_INDEX) as $id => $item) {
            $recipes = count($repo->all("item.toolFor.$id"));
            $repo->set("item.count.$id", "toolFor", $recipes);

            $recipes = count($repo->all("item.recipes.$id"));
            $repo->set("item.count.$id", "recipes", $recipes);

            $recipes = count($repo->all("item.learn.$id"));
            $repo->set("item.count.$id", "learn", $recipes);

            $recipes = count($repo->all("item.disassembly.$id"));
            $repo->set("item.count.$id", "disassembly", $recipes);

            $recipes = count($repo->all("item.disassembledFrom.$id"));
            $repo->set("item.count.$id", "disassembledFrom", $recipes);
        }
    }

    public function onNewObject(LocalRepository $repo, $object)
    {
        // only index objects with valid item types.
        if (!isset($this->types[$object->type])) {
            return;
        }

        $repo->set(self::DEFAULT_INDEX, $object->id, $object->repo_id);
        $repo->set(self::DEFAULT_INDEX.".".$object->id, $object->id, $object->repo_id);

        // nearby fire and integrated toolset are "virtual" items
        // they don't have anything special.
        if ($object->type == "_SPECIAL") {
            return;
        }

        // items with enough damage might be good melee weapons.
        if ($object->bashing+$object->cutting>10 and $object->to_hit>-2) {
            $repo->set("melee", $object->id, $object->repo_id);
        }

        // create an index with armor for each body part they cover.
        if ($object->type == "ARMOR" and !isset($object->covers)) {
            $repo->set("armor.none", $object->id, $object->repo_id);
        } elseif ($object->type == "ARMOR" and isset($object->covers)) {
            foreach ($object->covers as $part) {
                $part = strtolower($part);
                $repo->set("armor.$part", $object->id, $object->repo_id);
            }
        }

        if ($object->type == "CONTAINER") {
            $repo->set("container", $object->id, $object->repo_id);
        }
        if ($object->type == "COMESTIBLE") {
            $repo->set("food", $object->id, $object->repo_id);
        }
        if ($object->type == "TOOL") {
            $repo->set("tool", $object->id, $object->repo_id);
        }

        // save books per skill
        if ($object->type == "BOOK") {
            if (isset($this->book_types[$object->skill])) {
                $skill = $this->book_types[$object->skill];
                $repo->set("book.$skill", $object->id, $object->repo_id);
            } else {
                $repo->set("book.other", $object->id, $object->repo_id);
            }
        }

        if ($object->type == "GUN") {
            $repo->set("gun.$object->skill", $object->id, $object->repo_id);
        }

        if ($object->type == "GUNMOD") {
            foreach ($object->mod_targets as $target) {
                $repo->set("gunmods.$target.$object->location", $object->id, $object->repo_id);
                $repo->set("gunmodSkills", $target, $target);
            }
            $repo->set("gunmodParts", $object->location, $object->location);
        }

        if ($object->type == "AMMO") {
            $repo->set("ammo.$object->ammo_type", $object->id, $object->repo_id);
        }
        if ($object->type == "COMESTIBLE") {
            $type = strtolower($object->comestible_type);
            $repo->set("consumables.$type", $object->id, $object->repo_id);
        }
        if (isset($object->qualities)) {
            foreach ($object->qualities as $quality) {
                $repo->set("quality.$quality[0]", $object->id, $object->repo_id);
                $repo->set("qualities", $quality[0], $quality[0]);
            }
        }

        if (isset($object->material)) {
            $materials = (array) $object->material;
            $repo->set("material.$materials[0]", $object->id, $object->repo_id);
        }

        if (isset($object->flags)) {
            $flags = (array) $object->flags;
            foreach ($flags as $flag) {
                $repo->set("flag.$flag", $object->id, $object->repo_id);
                $repo->set("flags", $flag, $flag);
            }
        }
    }
}
