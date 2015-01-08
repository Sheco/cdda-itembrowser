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
        foreach ($repo->raw(self::DEFAULT_INDEX) as $id) {
            $recipes = count($repo->raw("item.toolFor.$id"));
            if($recipes>0)
                $repo->set("item.count.$id.toolFor", $recipes);

            $recipes = count($repo->raw("item.recipes.$id"));
            if($recipes>0)
                $repo->set("item.count.$id.recipes", $recipes);

            $recipes = count($repo->raw("item.learn.$id"));
            if($recipes>0)
                $repo->set("item.count.$id.learn", $recipes);

            $recipes = count($repo->raw("item.disassembly.$id"));
            if($recipes>0)
                $repo->set("item.count.$id.disassembly", $recipes);

            $recipes = count($repo->raw("item.disassembledFrom.$id"));
            if($recipes>0)
                $repo->set("item.count.$id.disassembledFrom", $recipes);
        }
    }

    public function onNewObject(LocalRepository $repo, $object)
    {
        // only index objects with valid item types.
        if (!isset($this->types[$object->type])) {
            return;
        }

        $repo->append(self::DEFAULT_INDEX,  $object->id);
        $repo->set(self::DEFAULT_INDEX.".".$object->id, $object->repo_id);

        // nearby fire and integrated toolset are "virtual" items
        // they don't have anything special.
        if ($object->type == "_SPECIAL") {
            return;
        }

        // items with enough damage might be good melee weapons.
        if ($object->bashing+$object->cutting>10 and $object->to_hit>-2) {
            $repo->append("melee", $object->id);
        }

        // create an index with armor for each body part they cover.
        if ($object->type == "ARMOR" and !isset($object->covers)) {
            $repo->append("armor.none", $object->id);
        } elseif ($object->type == "ARMOR" and isset($object->covers)) {
            foreach ($object->covers as $part) {
                $part = strtolower($part);
                $repo->append("armor.$part", $object->id);
            }
        }

        if ($object->type == "CONTAINER") {
            $repo->append("container", $object->id);
        }
        if ($object->type == "COMESTIBLE") {
            $repo->append("food", $object->id);
        }
        if ($object->type == "TOOL") {
            $repo->append("tool", $object->id);
        }

        // save books per skill
        if ($object->type == "BOOK") {
            if (isset($this->book_types[$object->skill])) {
                $skill = $this->book_types[$object->skill];
                $repo->append("book.$skill", $object->id);
            } else {
                $repo->append("book.other", $object->id);
            }
        }

        if ($object->type == "GUN") {
            $repo->append("gun.$object->skill", $object->id);
        }

        if ($object->type == "GUNMOD") {
            foreach ($object->mod_targets as $target) {
                $repo->append("gunmods.$target.$object->location", $object->id);
                $gunmodSkills = $repo->raw("gunmodSkills", array());
                $gunmodSkills[$target] = $target;
                $repo->set("gunmodSkills", $gunmodSkills);
            }
            $gunmodParts = $repo->raw("gunmodParts", array());
            $gunmodParts[$object->location] = $object->location;
            $repo->set("gunmodParts", $gunmodParts);
        }

        if ($object->type == "AMMO") {
            $repo->append("ammo.$object->ammo_type", $object->id);
        }
        if ($object->type == "COMESTIBLE") {
            $type = strtolower($object->comestible_type);
            $repo->append("consumables.$type", $object->id);
        }
        if (isset($object->qualities)) {
            foreach ($object->qualities as $quality) {
                $repo->append("quality.$quality[0]", $object->id);
            }
        }

        if (isset($object->material)) {
            $materials = (array) $object->material;
            $repo->append("material.$materials[0]", $object->id);
        }

        if (isset($object->flags)) {
            $flags = (array) $object->flags;
            foreach ($flags as $flag) {
                $repo->append("flag.$flag", $object->id);

                $flags = $repo->raw('flags', array());
                $flags[$flag] = $flag;
                $repo->set("flags", $flags);
            }
        }
    }
}
