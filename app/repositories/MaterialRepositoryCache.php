<?php

class MaterialRepositoryCache extends MaterialRepository
{
  const CACHE_KEY = "materialRepository";
  public function parse()
  {
    if(Cache::has(self::CACHE_KEY))
    {
      $this->database = Cache::get(self::CACHE_KEY);
      return;
    }
    $this->database = parent::read();
    Cache::put(self::CACHE_KEY, $this->database, 60);
  }

}

