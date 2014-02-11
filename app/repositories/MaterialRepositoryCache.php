<?php

class MaterialRepositoryCache extends MaterialRepository
{
  public function read()
  {
    $key = "materialRepository";
    if(Cache::has($key))
      return Cache::get($key);
    $cache = parent::read();
    Cache::put($key, $cache, 60);
    return $cache;
  }

}

