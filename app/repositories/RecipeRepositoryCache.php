<?php

class RecipeRepositoryCache extends RecipeRepository
{
  const CACHE_KEY = "recipeRepository";

  public function parse()
  {
    if(Cache::has(self::CACHE_KEY))
    {
      $this->database = Cache::get(self::CACHE_KEY);
      return;
    }
    $this->database = $this->read();

    $this->linkItems();
    $this->snapshot();
  }

  public function snapshot()
  {
    $this->item->snapshot();

    Cache::put(self::CACHE_KEY, $this->database, 60);
  }

}
