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

  protected function read()
  {
    $items = array();

    error_log("Building item database..");
    $path = \Config::get("cataclysm.dataPath");
    foreach(scandir("$path/items") as $file)
    {
      if($file[0]==".") continue;
      if($file=="ammo_types.json") continue;
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

}
