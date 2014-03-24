<?php
namespace Repositories;

class CacheReader implements RepositoryReaderInterface
{
  const CACHE_KEY="repository";

  private $reader;

  public function __construct(RepositoryReaderInterface $reader)
  {
    $this->reader = $reader;
  }

  public function read($path=null)
  {
    return $this->reader->read($path);
  }

  public function version()
  {
    return $this->reader->version();
  }

  public function loadObject($index, $id)
  {
    return \Cache::remember(self::CACHE_KEY."object:$index:$id", 60, 
      function () use ($index, $id)
    {
      return $this->reader->loadObject($index, $id);
    });
  }

  public function loadIndex($index)
  {
    return \Cache::remember(self::CACHE_KEY."index:$index", 60, 
      function () use ($index)
    {
      return $this->reader->loadIndex($index);
    });
  }
}
