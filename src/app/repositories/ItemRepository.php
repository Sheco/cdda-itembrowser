<?php 

class ItemRepository implements ItemRepositoryInterface
{
  protected $database;

  public function __construct()
  {
    $this->database = $this->read();
  }

  public function find($id)
  {
    $item = App::make('Item');
    if(isset($this->database[$id])) 
    {
      $item->load($this->database[$id]);
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
    foreach($this->database as $item)
    {
      $item = $this->find($item->id);
      if($item->matches($text))
      {
        $results[] = $this->find($item->id);
      }
    }
    return $results;
  }

  public function all()
  {
    return $this->database;
  }

  protected function read()
  {
    $items = array();
    $item_types = array_flip(array(
      "AMMO", "GUN", "ARMOR", "TOOL", "TOOL_ARMOR", "BOOK", "COMESTIBLE",
      "CONTAINER", "GUNMOD", "GENERIC", "BIONIC_ITEM", "VAR_VEH_PART"
    ));

    error_log("Building item database..");
    $path = \Config::get("cataclysm.dataPath");
    $it = new RecursiveDirectoryIterator(\Config::get("cataclysm.dataPath"));
    foreach(new RecursiveIteratorIterator($it) as $file)
    {
      $json = (array) json_decode(file_get_contents($file));
      foreach($json as $item)
      {
        if(!isset($item_types[$item->type]))
          continue;
        $item->recipes = array();
        $item->disassembly = array();
        $item->toolFor = array();
        $item->toolForCategory = array();
        $item->componentFor = array();
        $items[$item->id] = $item;
      }
    }

    $items["toolset"] = json_decode('{"id":"toolset","name":"integrated toolset","type":"none"}');
    $items["fire"] = json_decode('{"id":"fire","name":"nearby fire","type":"none"}');
    return $items;
  }

}
