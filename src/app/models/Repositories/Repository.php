<?php
namespace Repositories;

class Repository implements RepositoryInterface
{
  protected $reader;
  protected $loaded;

  public function __construct(RepositoryReaderInterface $reader)
  {
    $reader = new CompiledReader($reader);
    $reader = new CacheReader($reader);

    $this->reader = $reader;
    $this->loaded = false;
  }

  // lazy load
  private function load()
  {
    if ($this->loaded)
      return;

    $this->reader->read();
    $this->loaded = true;
  }

  // return a single object
  public function get($index, $id)
  {
    $this->load();
    return $this->reader->loadObject($index, $id);
  }

  // return all the objects in the index
  public function all($index)
  {
    $this->load();
    return $this->reader->loadIndex($index);
  }

  public function version()
  {
    return $this->reader->version();
  }
}
