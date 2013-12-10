<?php

class Items
{
  private static $database;

  public static function get($id)
  {
    if(isset(static::$database[$id])) 
    {
      return new Item(static::$database[$id]);
    }

    if(isset(static::$database["vehicle_parts/$id"]))
      return new Item(static::$database["vehicle_parts/$id"]);
    return new Item(json_decode('{"id":"'.$id.'","name":"?'.$id.'?"}'));
  }

  public static function search($text)
  {
    error_log("searching for $text...");
    if(Cache::has("search/$text"))
      return Cache::get("search/$text");
    error_log("fetching data for $text...");

    $results = [];
    foreach(static::$database as $item)
    {
      if($text=="" || 
          (isset($item->symbol) && $item->symbol==$text) || 
          stristr($item->id, $text) || 
          stristr($item->name, $text))
        $results[] = static::get($item->id);
    }
    Cache::add("search/$text", $results, 60);
    return $results;
  }

  public static function setup()
  {
    if(Cache::has('items'))  {
      static::$database = Cache::get('items');
      return;
    }

    static::$database = static::getItems();
    Cache::add('items', static::$database, 60);
    error_log("Building item database..");
  }

  private static function getItems()
  {
    $items = [];

    $path = Config::get("cataclysm.dataPath");
    foreach(scandir("$path\items") as $file)
    {
      if($file[0]==".") continue;
      $json = (array) json_decode(file_get_contents("$path/items/$file"));
      foreach($json as $item)
      {
        $item->recipes = [];
        $item->toolFor = [];
        $item->componentFor = [];
        $items[$item->id] = $item;
      }
    }
    $json = (array) json_decode(file_get_contents("$path/vehicle_parts.json"));
    foreach($json as $item)
    {
      $item->recipes = [];
      $item->toolFor = [];
      $item->componentFor = [];
      $items["$item->item"] = $item;
    }
    $json = (array) json_decode(file_get_contents("$path/bionics.json"));
    foreach($json as $item)
    {
      $item->recipes = [];
      $item->toolFor = [];
      $item->componentFor = [];
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

  public static function link($type, $id, $recipe_id)
  {
    $keys = [
        "result"=>"recipes",
        "tool"=>"toolFor",
        "component"=>"toolFor"
    ];
    $key = $keys[$type];
    if(isset(static::$database[$id]))
    {
      static::$database[$id]->{$key}[] = $recipe_id;
      return;
    }
    if(isset(static::$database["vehicle_parts/$id"]))
    {
      static::$database["vehicle_parts/$id"]->{$key}[] = $recipe_id;
      return;
    }
  }

}
