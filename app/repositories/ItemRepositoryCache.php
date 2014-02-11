<?php

class ItemRepositoryCache extends ItemRepository
{
  public function read()
  {
    $key = "itemRepository";
    if(Cache::has($key))
      return Cache::get($key);
    $cache = parent::read();
    Cache::put($key, $cache, 60);
    return $cache;
  }

}
