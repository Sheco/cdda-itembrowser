<?php
namespace Repositories;

class Json implements RepositoryInterface
{
  protected $index;
  protected $reader;
  protected $loaded;

  public function __construct(RepositoryReaderInterface $reader)
  {
    $this->index = array();
    $this->reader = new JsonCache($reader);
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
    $version_file = \Config::get("cataclysm.dataPath")."/../../src/version.h";
    $data = @file_get_contents($version_file);
    return substr($data, 17, -2);
  }
}
