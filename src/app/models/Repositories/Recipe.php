<?php
namespace Repositories;

class Recipe
{
  protected $repo;
  public function __construct(RepositoryInterface $repo)
  {
    $this->repo = $repo;
    \Event::listen("cataclysm.newObject", function ($repo, $object) {
      $this->getIndexes($repo, $object);
    });
  }

  private function linkIndexes($repo, $key, $id, $recipe)
  {
    if ($key=="recipes" 
      and $recipe->category=="CC_NONCRAFT") {
      $repo->index("item.disassembly.$id", $recipe->repo_id, $recipe);
      return;
    }
    if ($key=="recipes" 
      and isset($recipe->reversible) 
      and $recipe->reversible=="true") {
      $repo->index("item.disassembly.$id", $recipe->repo_id, $recipe);
    }

    if ($key=="toolFor") {
      if ($recipe->category!="CC_NONCRAFT")
        $repo->index("item.categories.$id", $recipe->category, $recipe);

      $repo->index("item.toolForCategory.$id.$recipe->category", 
        $recipe->repo_id, $recipe);
    }

    $repo->index("item.$key.$id", $recipe->repo_id, $recipe);
  }

  private function getIndexes($repo, $object)
  {
    if ($object->type=="recipe") {
      $recipe = $object;

      $repo->index("recipe", $recipe->repo_id, $recipe);
      if (isset($recipe->result)) {
        $this->linkIndexes($repo, "recipes", $recipe->result, $recipe);
        if (isset($recipe->book_learn)) {
          foreach($recipe->book_learn as $learn) {
            $this->linkIndexes($repo, "learn", $learn[0], $recipe);
          }
        }
      }
      if (isset($recipe->tools)) {
        foreach($recipe->tools as $group) {
          foreach($group as $tool) {
            list($id, $amount) = $tool;
            $this->linkIndexes($repo, "toolFor", $id, $recipe);
          }
        }
      }
      if (isset($recipe->components)) {
        foreach($recipe->components as $group) {
          foreach($group as $component) {
            list($id, $amount) = $component;
            $this->linkIndexes($repo, "toolFor", $id, $recipe);
          }
        }
      }
    }
  }

  public function find($id)
  {
    $recipe = \App::make('Recipe');
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
