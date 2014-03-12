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
    throw new Exception();
  }

  public function all()
  {
    return $this->database;
  }

  protected function read()
  {
    error_log("Building recipes database...");
    $types = array_flip(array(
      "recipe"
    ));

    $recipes = array();
    $it = new RecursiveDirectoryIterator(\Config::get("cataclysm.dataPath"));
    $id = 0;
    foreach(new RecursiveIteratorIterator($it) as $file)
    {
      $json = (array) json_decode(file_get_contents($file));
      foreach($json as $recipe)
      {
        if(!isset($types[$recipe->type]))
          continue;
        $recipe->id = $id++;
        $recipes[$recipe->id] = $recipe;
      }
    }
    return $recipes;
  }

}
