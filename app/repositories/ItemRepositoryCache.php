<?php

class ItemRepositoryCache extends ItemRepository
{
  const CACHE_KEY = "itemRepository";

  /* parse()
   * the item repository is executed in two stages
   * the first stage loads the file into memory
   * and the second stage is after the recipes are linked
   */
  public function parse()
  {
    if(Cache::has(self::CACHE_KEY))
    {
      $this->database = Cache::get(self::CACHE_KEY);
      return;
    }
    $this->database = parent::read();
    $this->snapshot();
  }


  /* snapshot()
   * save the current state of the database in the cache
   * this is to avoid linking recipes and items in each
   * request.
   */
  public function snapshot()
  {
    Cache::put(self::CACHE_KEY, $this->database, 60);
  }

}
