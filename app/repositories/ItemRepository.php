<?php 

class ItemRepository implements ItemRepositoryInterface
{
  protected $database;

  public function __construct()
  {
    $this->parse();
  }

  public function find($id)
  {
    $item = App::make('Item');
    if(isset($this->database[$id])) 
    {
      $item->load($this->database[$id]);
      return $item;  
    }

    if(isset($this->database["vehicle_parts/$id"]))
    {
      $item->load($this->database["vehicle_parts/$id"]);
      return $item;
    }
    $item->load(json_decode('{"id":"'.$id.'","name":"?'.$id.'?"}'));
    return $item;
  }

  public function where($text)
  {
    error_log("searching for $text...");

    $results = array();
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

  public function parse()
  {
    $this->database = $this->getItems();
  }

  private function getItems()
  {
    $items = array();

    error_log("Building item database..");
    $path = \Config::get("cataclysm.dataPath");
    foreach(scandir("$path/items") as $file)
    {
      if($file[0]==".") continue;
      $json = (array) json_decode(file_get_contents("$path/items/$file"));
      foreach($json as $item)
      {
        $item->recipes = array();
        $item->disassembly = array();
        $item->toolFor = array();
        $item->toolForCategory = array();
        $item->componentFor = array();
        $items[$item->id] = $item;
      }
    }
    $json = (array) json_decode(file_get_contents("$path/vehicle_parts.json"));
    foreach($json as $item)
    {
      $item->recipes = array();
      $item->disassembly = array();
      $item->toolFor = array();
      $item->toolForCategory = array();      
      $item->componentFor = array();
      $items["vehicle_parts/$item->item"] = $item;
      $items[$item->id] = $item;
    }
    $json = (array) json_decode(file_get_contents("$path/bionics.json"));
    foreach($json as $item)
    {
      $item->recipes = array();
      $item->disassembly = array();
      $item->toolFor = array();
      $item->toolForCategory = array();
      $item->componentFor = array();
      $item->weight = 2000;
      $item->volume = 10;
      $item->bashing = 8;
      $item->cutting = 0;
      $item->to_hit = 0;
      $items[$item->id] = $item;
    }

    $items["toolset"] = json_decode('{"id":"toolset","name":"integrated toolset"}');
    $items["fire"] = json_decode('{"id":"fire","name":"nearby fire"}');
    return $items;
  }

  public function link($type, $id, $recipe)
  {
    $keys = array(
        "result"=>"recipes",
        "tool"=>"toolFor",
        "component"=>"toolFor",
        "learn"=>"learn"
    );
    $key = $keys[$type];
    if(isset($this->database[$id]))
    {
      if($key=="recipes" and $recipe->category=="CC_NONCRAFT")
      {
        $this->database[$id]->disassembly[] = $recipe->id;
        return;
      }
      if($key=="toolFor")
      {
        $this->database[$id]->{"toolForCategory"}[$recipe->category][] = $recipe->id;
      }
      $this->database[$id]->{$key}[] = $recipe->id;
      return;
    }
    if(isset($this->database["vehicle_parts/$id"]))
    {
      $this->database["vehicle_parts/$id"]->{$key}[] = $recipe->id;
      return;
    }
  }
}
