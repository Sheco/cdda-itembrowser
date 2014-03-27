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

    \Event::listen("cataclysm.finishedLoading", function($repo)
    {
      $this->finishLoading($repo);
    });
  }

  private function finishLoading($repo)
  {
    foreach($repo->all('recipe') as $id)
    {
      $recipe = $repo->get("recipe", $id);
      // search for all the items with the apropiate qualities
      if (isset($recipe->qualities)) {
        foreach ($recipe->qualities as $group) {
          foreach($repo->all("quality.$group->id") as $id=>$item) {
            $item = \App::make("Item");
            $item->load($repo->get("item", $id));
            if($item->qualityLevel($group->id)<$group->level)
              continue;
            $this->linkIndexes($repo, 'toolFor', $id, $recipe);
          }
        }
      }
    }
  }

  private function linkIndexes($repo, $key, $id, $recipe)
  {
    // NONCRAFT recipes go directly to the disassembly index, 
    // they are not needed anywhere else.
    if ($key=="recipes" 
      and $recipe->category=="CC_NONCRAFT") {
      $repo->addIndex("item.disassembly.$id", $recipe->repo_id, $recipe->repo_id);
      return;
    }

    // reversible recipes go to the disassembly index,
    // but they're used to craft, so process further indexes.
    if ($key=="recipes" 
      and isset($recipe->reversible) 
      and $recipe->reversible=="true") {
      $repo->addIndex("item.disassembly.$id", $recipe->repo_id, $recipe->repo_id);
    }

    if ($key=="toolFor") {
      // create a list of recipe categories, excluding NONCRAFT.
      if ($recipe->category!="CC_NONCRAFT")
        $repo->addIndex("item.categories.$id", $recipe->category, $recipe->category);

      // create a list of tools per category for this object.
      $repo->addIndex("item.toolForCategory.$id.$recipe->category", 
        $recipe->repo_id, $recipe->repo_id);
    }

    $repo->addIndex("item.$key.$id", $recipe->repo_id, $recipe->repo_id);
  }

  private function getIndexes($repo, $object)
  {
    if ($object->type=="recipe") {
      $recipe = $object;

      $repo->addIndex("recipe", $recipe->repo_id, $recipe->repo_id);

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

  // locate and return a recipe object.
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

  // returns a list with every recipe object.
  public function all()
  {
    $ret = array();
    foreach($this->repo->all("recipe") as $id=>$recipe) {
      $ret[$id] = $this->find($id);
    }
    return $ret;
  }

  // return a list with every recipe object in certain index.
  public function index($index)
  {
    $ret = array();
    foreach($this->repo->all($index) as $id=>$recipe) {
      $ret[$id] = $this->find($id);
    }
    return $ret;
  }

  // return the contents of certain index, without creating recipe objects.
  public function indexRaw($index)
  {
    return $this->repo->all($index);
  }
}
