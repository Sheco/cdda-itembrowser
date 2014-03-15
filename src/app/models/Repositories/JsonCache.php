<?php
namespace Repositories;

class JsonCache extends Json implements RepositoryInterface
{
  const CACHE_KEY="json";
  protected function read()
  {
    $key = self::CACHE_KEY;

    $lock_fp = fopen(storage_path()."/cache/.json.lock", "w+");
    flock($lock_fp, LOCK_EX);

    if(\Cache::has("$key:chunks")) {
      $this->chunks = \Cache::get("$key:chunks");
      $this->index = \Cache::get("$key:index");

      flock($lock_fp, LOCK_UN);
      fclose($lock_fp);

      return;
    }

    parent::read();

    foreach($this->database as $chunk=>$data) {
      \Cache::put("$key:db:$chunk", $data, 60);
    }
    \Cache::put("$key:index", $this->index, 60);
    \Cache::put("$key:chunks", $this->chunks, 60);

    flock($lock_fp, LOCK_UN);
    fclose($lock_fp);
  }

  protected function chunk($chunk)
  {
    if(isset($this->database[$chunk]))
      return $this->database[$chunk];

    $key = self::CACHE_KEY;
    $this->database[$chunk] = \Cache::get("$key:db:$chunk");

    return $this->database[$chunk];
  }
}
