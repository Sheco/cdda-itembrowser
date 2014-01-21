<?php

class Recipes
{
  private static $database;

  public static function get($id)
  {
    if(isset(static::$database[$id])) 
      return new Recipe(static::$database[$id]);
  }

  public static function setup()
  {
    static::$database = static::getRecipes();
    static::linkItems();
  }

  private static function getRecipes()
  {
    if(Cache::has('recipes'))
      return Cache::get('recipes');
    error_log("Building recipes database...");

    $recipes = array();

    $path = Config::get("cataclysm.dataPath")."/recipes";
    foreach(scandir($path) as $file)
    {
      if($file[0]==".") continue;
      $json = (array) json_decode(file_get_contents("$path/$file"));
      foreach($json as $recipe)
      {
        $recipes[] = $recipe;
      }
    }
    Cache::add('recipes', $recipes, 60);
    return $recipes;
  }

  private static function linkItems()
  {
    foreach(static::$database as $recipe_id=>$recipe)
    {
      if(isset($recipe->result))
      {
        Items::link("result", $recipe->result, $recipe_id);
        if(isset($recipe->book_learn))
        {
          foreach($recipe->book_learn as $learn)
          {
            Items::link("learn", $learn[0], $recipe_id);
          }
        }
      }
      if(isset($recipe->tools))
      {
        foreach($recipe->tools as $group)
        {
          foreach($group as $tool)
          {
            list($id, $amount) = $tool;
            Items::link("tool", $id, $recipe_id);
          }
        }
      }
      if(isset($recipe->components)) 
      {
        foreach($recipe->components as $group)
        {
          foreach($group as $component)
          {
            list($id, $amount) = $component;
            Items::link("component", $id, $recipe_id);
          }
        }
      }
    }
  }
}
