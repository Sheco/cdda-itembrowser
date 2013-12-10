<?php

class Materials
{
  private static $database;

  public static function get($id)
  {
    static::setup();
    return static::$database[$id];
  }

  public static function search($text)
  {
    static::setup();
    $return = array();
    foreach(static::$database as $item)
    {
      if($text=="" || stristr($item->id, $text) || stristr($item->name, $text))
        $return[] = $item;
    }
    return $return;
  }

  public static function setup()
  {
    if(static::$database == null) 
    {
      static::$database = static::getItems();
    }
  }

  private static function getItems()
  {
    if(Cache::has('materials'))
      return Cache::get('materials');
    error_log("reading materials...");

    $items = [];
    
    $path = Config::get("cataclysm.dataPath");
    $file = "materials.json";
    {
      if($file[0]==".") continue;
      $json = (array) json_decode(file_get_contents("$path/$file"));
      foreach($json as $item)
      {
        $items[$item->ident] = $item;

      }
    }
    Cache::add('materials', $items, 60);
    return $items;
  }
}
