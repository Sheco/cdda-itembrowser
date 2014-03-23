<?php
namespace Repositories;

use Illuminate\Cache\CacheManager;

class RepositoryCache implements RepositoryReaderInterface
{
  const CACHE_KEY="repository";
  private $dataChunks;
  private $indexChunks;

  private $reader;

  private $itemsPerCache;

  public function __construct(RepositoryReaderInterface $reader)
  {
    $this->dataChunks = array();
    $this->indexChunks = array();
    $this->indexHashSize = null;
    $this->reader = $reader;
    $this->itemsPerCache = \Config::get("cataclysm.itemsPerCache", 100);
  }

  public function read()
  {
    $key = self::CACHE_KEY;

    // create a exclusive read lock, to any file, just to block
    $lock_fp = fopen(base_path()."/composer.json", "r");
    flock($lock_fp, LOCK_EX);

    if(\Cache::has("$key:loaded")) {
      $this->indexHashSize = \Cache::get("$key:indexHashSize");
      flock($lock_fp, LOCK_UN);
      fclose($lock_fp);

      return;
    }

    $expiration = \Config::get("cataclysm.dataCacheExpiration");
    // clear all cache, this ensures searches are read again.
    \Cache::flush();

    list($database, $index) = $this->reader->read();

    $database = $this->chopDatabase($database);
    foreach($database as $chunk=>$data) {
      \Cache::forever("$key:db:$chunk", $data);
    }

    $this->indexHashSize = $this->makeIndexHashSize($index);

    $index = $this->chopIndex($index);
    foreach($index as $chunk=>$data)
    {
      \Cache::forever("$key:index:$chunk", $data);
    }

    \Cache::forever("$key:indexHashSize", $this->indexHashSize);

    \Cache::put("$key:loaded", true, $expiration);

    flock($lock_fp, LOCK_UN);
    fclose($lock_fp);
  }

  private function makeDatabaseHash($repo_id)
  {
    return intval($repo_id/$this->itemsPerCache);
  }

  private function chopDatabase($database)
  {
    $chunks = array();
    $newDatabase = array();
    foreach($database as $repo_id=>$object) {
      $chunk = $this->makeDatabaseHash($repo_id);
      $chunks[$repo_id] = $chunk;
      $newDatabase[$chunk][$repo_id] = $object;
    }
    return $newDatabase;
  }

  public function loadObject($index, $id)
  {
    $indexDb = $this->loadIndex($index);
    if(!isset($indexDb[$id])) 
      return null;

    $repo_id = $indexDb[$id];

    if(isset($this->database[$repo_id]))
      return $this->database[$repo_id];

    $chunk = $this->makeDatabaseHash($repo_id);

    if(!isset($this->dataChunks[$chunk])) {
      $key = self::CACHE_KEY;
      $this->dataChunks[$chunk] = \Cache::get("$key:db:$chunk");
    }
    $this->database[$repo_id] = $this->dataChunks[$chunk][$repo_id];
    return $this->database[$repo_id];
  }


  private function makeIndexHashSize($index)
  {
    return count($index)/$this->itemsPerCache;
  }

  private function makeIndexHash($index)
  {
    $size = $this->indexHashSize;

    // the item index is quite big by itself, use a chunk just for it.
    if ($index=="item") 
      return 0;

    // the recipe index is common enough to be in a chunk by itself.
    if ($index=="recipe")
      return 1;

    return abs(intval(base_convert($index, 16, 10)/$size)%$size)+2;
  }

  private function chopIndex($database)
  {
    $chunks = array();
    $newDatabase = array();
    foreach($database as $index=>$data) {
      $chunk = $this->makeIndexHash($index);
      $chunks[$index] = $chunk;
      $newDatabase[$chunk][$index] = $data;
    }
    return $newDatabase;
  }

  public function loadIndex($index)
  {
    if(isset($this->index[$index])) 
      return $this->index[$index];

    $chunk = $this->makeIndexHash($index);
    if(!isset($this->indexChunks[$chunk])) {
      $key = self::CACHE_KEY;
      $this->indexChunks[$chunk] = \Cache::get("$key:index:$chunk");
    }

    if(!isset($this->indexChunks[$chunk][$index]))
      return array();

    $this->index[$index] = $this->indexChunks[$chunk][$index];
    return $this->index[$index];
  }

  public function addIndex($index, $key, $value)
  {
    $this->reader->addIndex($index, $key, $value);
  }
}
