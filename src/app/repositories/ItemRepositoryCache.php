<?php

class ItemRepositoryCache extends ItemRepository
{
  const CACHE_KEY = "itemRepository";

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

  public function where($text)
  {
    $items = Cache::remember("itemSearch::$text", 60, function() use ($text) {
      $results = parent::where($text);
      // convert the results into an array of IDs
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
