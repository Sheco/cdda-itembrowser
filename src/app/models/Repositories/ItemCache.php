<?php 
namespace Repositories;

class ItemCache extends Item 
{
  const CACHE_KEY = "itemSearch";
  public function where($text)
  {
    $key = self::CACHE_KEY.":$text";
    $items = \Cache::remember($key, 60, function () use ($text) {
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
