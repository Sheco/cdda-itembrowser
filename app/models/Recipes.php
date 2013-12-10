<?php

class Recipes
{
  private static $database;

  public static function setup()
  {
    static::$database = static::getRecipes();
    static::linkItems();
  }

  private static function getRecipes()
  {
    $recipes = [];

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
    error_log("Building recipes database...");
    return $recipes;
  }

  private static function linkItems()
  {
    foreach(static::$database as $recipe)
    {
      if(isset($recipe->result))
      {
        Items::linkToRecipe($recipe->result, "result", $recipe);
      }
      if(isset($recipe->tools))
      {
        foreach($recipe->tools as $group)
        {
          foreach($group as $tool)
          {
            list($id, $amount) = $tool;
            Items::linkToRecipe($id, "tool", $recipe);
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
            Items::linkToRecipe($id, "component", $recipe);
          }
        }
      }
    }
  }
}
