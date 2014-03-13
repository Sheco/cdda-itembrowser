<?php 

class ItemRepository implements ItemRepositoryInterface, IndexerInterface
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
    Event::listen("cataclysm.newObject", function($repo, $object)
    {
      $this->getIndexes($repo, $object);
    });
  }


  private function getIndexes($repo, $object)
  {
    if(!isset($this->types[$object->type]))
      return;
    $repo->addIndex("item", $object->id, $object);
    if($object->type=="_SPECIAL")
      return;
    if($object->bashing+$object->cutting>10 and $object->to_hit>-2)
    {
      $repo->addIndex("melee", $object->id, $object);
    }
    if($object->type=="ARMOR" and !isset($object->covers)) 
    {
      $repo->addIndex("armor.none", $object->id, $object);
    } 
    else if($object->type=="ARMOR" and isset($object->covers))
    {
      if(in_array("FEET", $object->covers))
        $repo->addIndex("armor.feet", $object->id, $object);
      if(in_array("ARMS", $object->covers))
        $repo->addIndex("armor.arms", $object->id, $object);
      if(in_array("EYES", $object->covers))
        $repo->addIndex("armor.eyes", $object->id, $object);
      if(in_array("LEGS", $object->covers))
        $repo->addIndex("armor.legs", $object->id, $object);
      if(in_array("HANDS", $object->covers))
        $repo->addIndex("armor.hands", $object->id, $object);
      if(in_array("TORSO", $object->covers))
        $repo->addIndex("armor.torso", $object->id, $object);
      if(in_array("HEAD", $object->covers))
        $repo->addIndex("armor.head", $object->id, $object);
      if(in_array("MOUTH", $object->covers))
        $repo->addIndex("armor.mouth", $object->id, $object);
    }
    if($object->type=="CONTAINER")
      $repo->addIndex("container", $object->id, $object);
    if($object->type=="COMESTIBLE")
      $repo->addIndex("food", $object->id, $object);
    if($object->type=="TOOL")
      $repo->addIndex("tool", $object->id, $object);
    if($object->type=="BOOK")
    {
      if($object->skill=="none")
      {
        if($object->fun>0)
          $repo->addIndex("book.entertainment", $object->id, $object);
        else
          $repo->addIndex("book.boring", $object->id, $object);
      } else if(in_array($object->skill, array(
        "archery", "handguns", "markmanship",
        "launcher", "firearms", "throw", "rifle",
        "shotgun", "smg", "pistol", "gun")))
        $repo->addIndex("book.range", $object->id, $object);
      else if(in_array($object->skill, array(
        "bashing", "cutting", "stabbing", "dodge",
        "melee", "unarmed")))
        $repo->addIndex("book.combat", $object->id, $object);
      else if(in_array($object->skill, array(
        "computer", "electronics", "fabrication",
        "mechanics", "construction", "carpentry",
        "traps")))
        $repo->addIndex("book.engineering", $object->id, $object);
      else if(in_array($object->skill, array(
        "cooking", "tailor", "firstaid")))
        $repo->addIndex("book.crafts", $object->id, $object);
      else if(in_array($object->skill, array(
        "barter", "speech")))
        $repo->addIndex("book.social", $object->id, $object);
      else if(in_array($object->skill, array(
        "driving", "survival", "swimming")))
        $repo->addIndex("book.survival", $object->id, $object);
      else 
        $repo->addIndex("book.other", $object->id, $object);
    }
  }

  public function find($id)
  {
    $item = App::make('Item');
    $data = $this->repo->get("item", $id);
    if($data) 
    {
      $item->load($data);
      return $item;  
    }

    $item->load(json_decode('{"id":"'.$id.'","name":"?'.$id.'?","type":"invalid"}'));
    return $item;
  }

  public function where($text)
  {
    error_log("searching for $text...");

    $results = array();
    if(!$text)
      return $results;
    foreach($this->all() as $id=>$val)
    {
      $item = $this->find($id);
      if($item->matches($text))
      {
        $results[] = $item;
      }
    }
    return $results;
  }

  public function all()
  {
    return $this->repo->all("item");;
  }

  public function index($name)
  {
    return $this->repo->all($name);
  }
}
