<?php 
namespace Repositories;

class ItemCache extends Item 
{
  const CACHE_KEY = "itemSearch";
  public function where($text)
  {
    $key = self::CACHE_KEY.":$text";
    return \Cache::remember($key, 60, function () use ($text) {
      return parent::where($text);
    });

  }
}
