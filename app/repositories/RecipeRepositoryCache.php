<?php

class RecipeRepositoryCache extends RecipeRepository
{
  public function read()
  {
    $key = "recipeRepository";
    if(Cache::has($key))
      return Cache::get($key);
    $cache = parent::read();
    Cache::put($key, $cache, 60);
    return $cache;
  }
}
