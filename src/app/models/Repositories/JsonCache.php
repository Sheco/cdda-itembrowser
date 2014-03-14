<?php 
namespace Repositories;

class JsonCache extends Json implements RepositoryInterface
{
  const CACHE_KEY="json";
  protected function read()
  {
    $key = self::CACHE_KEY;
    if(\Cache::has("$key:hashes"))
    {
      $this->hashes = \Cache::get("$key:hashes");
      $this->index = \Cache::get("$key:index");
      return;
    }

    parent::read();
    foreach($this->database as $hash=>$data)
    {
      \Cache::put("$key:db:$hash", $data, 60);
    }
    \Cache::put("$key:index", $this->index, 60);
    \Cache::put("$key:hashes", $this->hashes, 60);
  }

  protected function checkHash($hash)
  {
    if(isset($this->database[$hash]))
      return;
    $key = self::CACHE_KEY;
    $this->database[$hash] = \Cache::get("$key:db:$hash");
  }
}
