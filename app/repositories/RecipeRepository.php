<?php

class RecipeRepository implements RecipeRepositoryInterface
{
  protected $database;
  protected $item;
  protected $config;

  public function __construct(ItemRepositoryInterface $item, Config $config)
  {
    $this->item = $item;
    $this->config = $config;
    $this->parse();
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

  protected function parse()
  {
    $this->database = $this->read();
    $this->linkItems();
  }

  protected function read()
  {
    error_log("Building recipes database...");

    $recipes = array();
    $dataPath = $this->config->get("cataclysm.dataPath");
    if(file_exists("$dataPath/recipes.json"))
    {
      $path = $dataPath;
      $files = array("recipes.json");
    }
    else
    {
      $path = "$dataPath/recipes";
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

  protected function linkItems()
  {
    foreach($this->database as $recipe_id=>$recipe)
    {
      if(isset($recipe->result))
      {
        $this->item->link("result", $recipe->result, $recipe);
        if(isset($recipe->book_learn))
        {
          foreach($recipe->book_learn as $learn)
          {
            $this->item->link("learn", $learn[0], $recipe);
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
            $this->item->link("tool", $id, $recipe);
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
            $this->item->link("component", $id, $recipe);
          }
        }
      }
    }
  }
}
