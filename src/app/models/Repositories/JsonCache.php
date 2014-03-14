<?php 
namespace Repositories;

class JsonCache extends Json implements RepositoryInterface
{
  const CACHE_KEY="json";
  protected function read()
  {
    $key = self::CACHE_KEY;
    if(\Cache::has("$key:chunks"))
    {
      $this->chunks = \Cache::get("$key:chunks");
      $this->index = \Cache::get("$key:index");
      return;
    }

    parent::read();
    foreach($this->database as $chunk=>$data)
    {
      \Cache::put("$key:db:$chunk", $data, 60);
    }
    \Cache::put("$key:index", $this->index, 60);
    \Cache::put("$key:chunks", $this->chunks, 60);
  }

  protected function checkChunk($chunk)
  {
    if(isset($this->database[$chunk]))
      return;
    $key = self::CACHE_KEY;
    $this->database[$chunk] = \Cache::get("$key:db:$chunk");
  }
}
