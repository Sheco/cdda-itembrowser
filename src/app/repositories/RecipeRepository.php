<?php

class RecipeRepository implements RecipeRepositoryInterface
{
  protected $database;

  public function __construct()
  {
    $this->database = $this->read();
  }

  public function find($id)
  {
    $recipe = App::make('Recipe');
    $recipe->load($this->database[$id]);
    return $recipe;  
  }

  public function where($text)
  {
    //TODO: make a real search
    //right now, the search is only used to feed the ItemRecipePivot
    return array_filter($this->database, function($recipe)
    {
      return true;     
    });
  }

  protected function read()
  {
    error_log("Building recipes database...");

    $recipes = array();

    if(file_exists(\Config::get("cataclysm.dataPath")."/recipes.json"))
    {
      $path = \Config::get("cataclysm.dataPath");
      $files = array("recipes.json");
    }
    else
    {
      $path = \Config::get("cataclysm.dataPath")."/recipes";
      $files = scandir($path);
    }

    foreach($files as $file)
    {
      if($file[0]==".") continue;
      $json = (array) json_decode(file_get_contents("$path/$file"));
      foreach($json as $id=>$recipe)
      {
        $recipe->id = $id;
        $recipes[] = $recipe;
      }
    }
    return $recipes;
  }

}
