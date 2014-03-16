<?php 
namespace Repositories;

class Item
{
  protected $repo;
  protected $types;

  public function __construct(RepositoryInterface $repo)
  {
    $this->repo = $repo;
    $this->types = array_flip(array(
      "AMMO", "GUN", "ARMOR", "TOOL", "TOOL_ARMOR", "BOOK", "COMESTIBLE",
      "CONTAINER", "GUNMOD", "GENERIC", "BIONIC_ITEM", "VAR_VEH_PART",
      "_SPECIAL",
    ));
    \Event::listen("cataclysm.newObject", function ($repo, $object) {
      $this->getIndexes($repo, $object);
    });
  }


  private function getIndexes($repo, $object)
  {
    if (!isset($this->types[$object->type]))
      return;
    $repo->index("item", $object->id, $object->repo_id);
    if ($object->type=="_SPECIAL")
      return;
    if ($object->bashing+$object->cutting>10 and $object->to_hit>-2) {
      $repo->index("melee", $object->id, $object->repo_id);
    }
    if ($object->type=="ARMOR" and !isset($object->covers)) {
      $repo->index("armor.none", $object->id, $object->repo_id);
    } 
    else if ($object->type=="ARMOR" and isset($object->covers)) {
      if (in_array("FEET", $object->covers))
        $repo->index("armor.feet", $object->id, $object->repo_id);
      if (in_array("ARMS", $object->covers))
        $repo->index("armor.arms", $object->id, $object->repo_id);
      if (in_array("EYES", $object->covers))
        $repo->index("armor.eyes", $object->id, $object->repo_id);
      if (in_array("LEGS", $object->covers))
        $repo->index("armor.legs", $object->id, $object->repo_id);
      if (in_array("HANDS", $object->covers))
        $repo->index("armor.hands", $object->id, $object->repo_id);
      if (in_array("TORSO", $object->covers))
        $repo->index("armor.torso", $object->id, $object->repo_id);
      if (in_array("HEAD", $object->covers))
        $repo->index("armor.head", $object->id, $object->repo_id);
      if (in_array("MOUTH", $object->covers))
        $repo->index("armor.mouth", $object->id, $object->repo_id);
    }
    if ($object->type=="CONTAINER")
      $repo->index("container", $object->id, $object->repo_id);
    if ($object->type=="COMESTIBLE")
      $repo->index("food", $object->id, $object->repo_id);
    if ($object->type=="TOOL")
      $repo->index("tool", $object->id, $object->repo_id);
    if ($object->type=="BOOK") {
      if ($object->skill=="none") {
        if ($object->fun>0)
          $repo->index("book.entertainment", $object->id, $object->repo_id);
        else
          $repo->index("book.boring", $object->id, $object->repo_id);
      } else if (in_array($object->skill, array(
        "archery", "handguns", "markmanship",
        "launcher", "firearms", "throw", "rifle",
        "shotgun", "smg", "pistol", "gun")))
        $repo->index("book.range", $object->id, $object->repo_id);
      else if (in_array($object->skill, array(
        "bashing", "cutting", "stabbing", "dodge",
        "melee", "unarmed")))
        $repo->index("book.combat", $object->id, $object->repo_id);
      else if (in_array($object->skill, array(
        "computer", "electronics", "fabrication",
        "mechanics", "construction", "carpentry",
        "traps")))
        $repo->index("book.engineering", $object->id, $object->repo_id);
      else if (in_array($object->skill, array(
        "cooking", "tailor", "firstaid")))
        $repo->index("book.crafts", $object->id, $object->repo_id);
      else if (in_array($object->skill, array(
        "barter", "speech")))
        $repo->index("book.social", $object->id, $object->repo_id);
      else if (in_array($object->skill, array(
        "driving", "survival", "swimming")))
        $repo->index("book.survival", $object->id, $object->repo_id);
      else 
        $repo->index("book.other", $object->id, $object->repo_id);
    }
    if($object->type=="GUN") {
      $repo->index("gun.$object->skill", $object->id, $object->repo_id);
    }
    if($object->type=="AMMO") {
      $repo->index("ammo.$object->ammo_type", $object->id, $object->repo_id);
    }

  }

  public function find($id)
  {
    $item = \App::make('Item');
    $data = $this->repo->get("item", $id);
    $item->load($data?:
      json_decode('{"id":"'.$id.'","name":"'.$id.'?","type":"invalid"}')
    );
    return $item;
  }

  public function findOr404($id)
  {
    $item = $this->find($id);
    if($item->type=="invalid")
      \App::abort(404);
    return $item;
  }

  public function where($text)
  {
    \Log::info("searching for $text...");

    $results = array();
    if (!$text)
      return $results;
    foreach($this->all() as $item) {
      if ($item->matches($text)) {
        $results[] = $item;
      }
    }
    return $results;
  }

  public function all()
  {
    $ret = array();
    foreach($this->repo->all("item") as $id=>$item) {
      $ret[$id] = $this->find($id);
    }
    return $ret;
  }

  public function index($name)
  {
    $ret = array();
    foreach($this->repo->all($name) as $id=>$item) {
      $ret[$id] = $this->find($id);
    }
    return $ret;
  }

  public function indexRaw($index)
  {
    return $this->repo->all($index);
  }
}
