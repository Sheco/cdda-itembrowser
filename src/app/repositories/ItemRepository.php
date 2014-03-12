<?php 

class ItemRepository implements ItemRepositoryInterface, IndexerInterface
{
  protected $repo;
  protected $types;

  public function __construct(RepositoryInterface $repo)
  {
    $this->repo = $repo;
    $repo->registerIndexer($this);
    $this->types = array_flip(array(
      "AMMO", "GUN", "ARMOR", "TOOL", "TOOL_ARMOR", "BOOK", "COMESTIBLE",
      "CONTAINER", "GUNMOD", "GENERIC", "BIONIC_ITEM", "VAR_VEH_PART"
    ));
  }


  public function getIndexes($object)
  {
    $indexes = array();
    if(!isset($this->types[$object->type]))
      return $indexes;
    $indexes["item"] = $object->id;
    if($object->type=="ARMOR" and !isset($object->covers)) 
    {
        $indexes["armor.none"] = $object->id;
    } 
    else if($object->type=="ARMOR" and isset($object->covers))
    {
      if(in_array("FEET", $object->covers))
      {
        $indexes["armor.feet"] = $object->id;
      }
      if(in_array("ARMS", $object->covers))
      {
        $indexes["armor.arms"] = $object->id;
      }
      if(in_array("EYES", $object->covers))
      {
        $indexes["armor.eyes"] = $object->id;
      }
      if(in_array("LEGS", $object->covers))
      {
        $indexes["armor.legs"] = $object->id;
      }
      if(in_array("HANDS", $object->covers))
      {
        $indexes["armor.hands"] = $object->id;
      }
      if(in_array("TORSO", $object->covers))
      {
        $indexes["armor.torso"] = $object->id;
      }
      if(in_array("HEAD", $object->covers))
      {
        $indexes["armor.head"] = $object->id;
      }
      if(in_array("MOUTH", $object->covers))
      {
        $indexes["armor.mouth"] = $object->id;
      }
    }
    if($object->type=="CONTAINER")
      $indexes["container"] = $object->id;
    if($object->type=="COMESTIBLE")
      $indexes["food"] = $object->id;
    if($object->type=="TOOL")
      $indexes["tool"] = $object->id;
    if($object->type=="BOOK")
    {
      if($object->skill=="none")
      {
        if($object->fun>0)
          $indexes["book.entertainment"] = $object->id;
        else
          $indexes["book.boring"] = $object->id;
      } else if(in_array($object->skill, array(
        "archery", "handguns", "markmanship",
        "launcher", "firearms", "throw", "rifle",
        "shotgun", "smg", "pistol", "gun")))
      {
        $indexes["book.range"] = $object->id;
      } 
      else if(in_array($object->skill, array(
        "bashing", "cutting", "stabbing", "dodge",
        "melee", "unarmed")))
      {
        $indexes["book.combat"] = $object->id;
      } 
      else if(in_array($object->skill, array(
        "computer", "electronics", "fabrication",
        "mechanics", "construction", "carpentry",
        "traps")))
      {
        $indexes["book.engineering"] = $object->id;
      } 
      else if(in_array($object->skill, array(
        "cooking", "tailor", "firstaid")))
      {
        $indexes["book.crafts"] = $object->id;
      } 
      else if(in_array($object->skill, array(
        "barter", "speech")))
      {
        $indexes["book.social"] = $object->id;
      } 
      else if(in_array($object->skill, array(
        "driving", "survival", "swimming")))
      {
        $indexes["book.survival"] = $object->id;
      } 
      else 
      {
        $indexes["book.other"] = $object->id;
      }
      

    }

    //TODO: check extra indexes (armor, melee, books, etc)
    return $indexes;
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

}
