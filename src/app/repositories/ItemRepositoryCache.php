<?php

class ItemRepositoryCache extends ItemRepository
{
  const CACHE_KEY = "itemRepository";

  /* parse()
   * the item repository is executed in two stages
   * the first stage loads the file into memory
   * and the second stage is after the recipes are linked
   */
  protected function parse()
  {
    if(Cache::has(self::CACHE_KEY))
    {
      $this->database = Cache::get(self::CACHE_KEY);
      return;
    }
    $this->database = parent::read();
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


  public function where($text)
  {
    // convert the results into an array of IDs
    $items = Cache::remember("itemSearch::$text", 60, function() use ($text) {
      $results = parent::where($text);
      array_walk($results, function(&$item) { 
        $item = $item->id;
      });
      return $results;
    });

    // expand the array back into full items
    array_walk($items, function(&$item) {
      $item = $this->find($item);
    });
    return $items;
  }
}
