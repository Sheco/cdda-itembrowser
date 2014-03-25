<?php 
namespace Repositories;

class ItemCache extends Item 
{
  const CACHE_KEY = "itemSearch";
  public function where($text)
  {
    $text = str_replace("_", " ", $text);
    $key = self::CACHE_KEY.":".str_replace(" ", "_", $text);
    $expiration = \Config::get("cataclysm.searchCacheExpiration");
    $items = \Cache::remember($key, $expiration, function () use ($text) {
      $items = parent::where($text);
      array_walk($items, function (&$item) { 
        $item = $item->id;
      });
      return $items;
    });

    array_walk($items, function (&$item) {
      $item = $this->find($item);
    });
    return $items;

  }
}
