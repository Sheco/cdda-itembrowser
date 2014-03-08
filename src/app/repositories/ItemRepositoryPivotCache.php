<?php

class ItemRepositoryPivotCache extends ItemRepositoryPivot
{
  const CACHE_KEY = "ItemRepositoryPivot";

  protected function read()
  {
    if(Cache::has(self::CACHE_KEY))
    {
      return Cache::get(self::CACHE_KEY);
    }
    $database = parent::read();
    Cache::put(self::CACHE_KEY, $database, 60);
    return $database;
  }

}
