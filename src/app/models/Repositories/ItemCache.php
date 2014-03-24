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
      return array_map(function ($item) { 
        return $item->id;
      }, parent::where($text));
      return $result;
    });

    return array_map(function ($item) {
      return $this->find($item);
    }, $items);

  }
}
