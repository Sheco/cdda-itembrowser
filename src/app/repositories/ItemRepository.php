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
    if(isset($this->types[$object->type]))
    {
      $indexes["item"] = $object->id;
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
