<?php
namespace Repositories;

class CompiledReader implements RepositoryReaderInterface
{
  const CACHE_KEY="repository";
  private $dataChunks;
  private $indexChunks;

  private $reader;

  private $adhesion;
  private $repo;

  public function __construct(LocalReader $reader)
  {
    $this->repo = new \Illuminate\Cache\Repository(
      new \Illuminate\Cache\FileStore(
        new \Illuminate\Filesystem\FileSystem, 
        storage_path()."/database"
      )
    );

    $this->dataChunks = array();
    $this->indexChunks = array();

    $this->indexHashSize = null;

    $this->reader = $reader;
  }

  public function read($path=null)
  {
    $key = self::CACHE_KEY;
    $this->adhesion = $this->repo->get("$key:adhesion");
    $this->indexHashSize = $this->repo->get("$key:indexHashSize");
  }

  public function compile($path, $adhesion=100)
  {
    if(!$path)
      $path = \Config::get('cataclysm.dataPath');

    $key = self::CACHE_KEY;

    $this->adhesion = $adhesion;

    // clear all cache, this ensures searches are read again.
    $this->repo->flush();

    list($database, $index) = $this->reader->read($path);

    $database = $this->chopDatabase($database);
    foreach($database as $chunk=>$data) {
      $this->repo->forever("$key:db:$chunk", $data);
    }

    $this->indexHashSize = $this->makeIndexHashSize($index);

    $index = $this->chopIndex($index);
    foreach($index as $chunk=>$data)
    {
      $this->repo->forever("$key:index:$chunk", $data);
    }
    $this->repo->forever("$key:version", $this->reader->version());
    $this->repo->forever("$key:adhesion", $this->adhesion);
    $this->repo->forever("$key:indexHashSize", $this->indexHashSize);
  }

  private function makeDatabaseHash($repo_id)
  {
    return intval($repo_id/$this->adhesion);
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

  public function get($index, $id)
  {
    $indexDb = $this->all($index);
    if(!isset($indexDb[$id])) 
      return null;

    $repo_id = $indexDb[$id];

    if(isset($this->database[$repo_id]))
      return $this->database[$repo_id];

    $chunk = $this->makeDatabaseHash($repo_id);

    if(!isset($this->dataChunks[$chunk])) {
      $key = self::CACHE_KEY;
      $this->dataChunks[$chunk] = $this->repo->get("$key:db:$chunk");
    }
    $this->database[$repo_id] = $this->dataChunks[$chunk][$repo_id];
    return $this->database[$repo_id];
  }


  private function makeIndexHashSize($index)
  {
    return intval(count($index)/$this->adhesion);
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

  public function all($index)
  {
    if(isset($this->index[$index])) 
      return $this->index[$index];

    $chunk = $this->makeIndexHash($index);
    if(!isset($this->indexChunks[$chunk])) {
      $key = self::CACHE_KEY;
      $this->indexChunks[$chunk] = $this->repo->get("$key:index:$chunk");
    }

    if(!isset($this->indexChunks[$chunk][$index]))
      return array();

    $this->index[$index] = $this->indexChunks[$chunk][$index];
    return $this->index[$index];
  }

  public function version()
  {
    $key = self::CACHE_KEY;

    return $this->repo->get("$key:version");
  }
}
