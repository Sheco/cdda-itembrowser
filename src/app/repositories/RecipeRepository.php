<?php

class RecipeRepository implements RecipeRepositoryInterface, IndexerInterface
{
  protected $repo;
  public function __construct(RepositoryInterface $repo)
  {
    $this->repo = $repo;
    $repo->registerIndexer($this);
  }

  private function linkIndexes(&$indexes, $key, $id, $recipe)
  {
    if($key=="recipes" and $recipe->category=="CC_NONCRAFT")
    {
      $indexes["item.disassembly.$id"] = $recipe->repo_id;
      return;
    }
    if($key=="recipes" and isset($recipe->reversible) and $recipe->reversible=="true")      
    {
      $indexes["item.disassembly.$id"] = $recipe->repo_id;
    }

    if($key=="toolFor")
    {
      if($recipe->category!="CC_NONCRAFT")
        $indexes["item.categories.$id"] = $recipe->category;
      $indexes["item.toolForCategory.$id.$recipe->category"] = $recipe->repo_id;
    }

    $indexes["item.$key.$id"] = $recipe->repo_id;
  }

  public function getIndexes($object)
  {
    $indexes = array();
    if($object->type=="recipe")
    {
      $recipe = $object;
      $indexes["recipe"] = $recipe->repo_id;
      if(isset($recipe->result))
      {
        $this->linkIndexes($indexes, "recipes", $recipe->result, $recipe);
        if(isset($recipe->book_learn))
        {
          foreach($recipe->book_learn as $learn)
          {
            $this->linkIndexes($indexes, "learn", $learn[0], $recipe);
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
            $this->linkIndexes($indexes, "toolFor", $id, $recipe);
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
            $this->linkIndexes($indexes, "toolFor", $id, $recipe);
          }
        }
      }
    }
    return $indexes;  
  }

  public function find($id)
  {
    $recipe = App::make('Recipe');
    $recipe->load($this->repo->get("recipe", $id));
    return $recipe;  
  }

  public function where($text)
  {
    throw new Exception();
  }

  public function all()
  {
    return $this->repo->all("recipe");
  }

  public function index($index)
  {
    return $this->repo->all($index);
  }
}
