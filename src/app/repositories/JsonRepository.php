<?phP

class JsonRepository implements RepositoryInterface
{
  protected $database;
  protected $index;
  private $used_index;
  private $id;

  public function __construct()
  {
    $this->id = 0;
    $this->index = array();
    $this->used_index = array();
    $this->database = array();
  }

  // lazy load
  private function load()
  {
    if ($this->database)
      return;

    $this->read();
  }

  private function newObject($object)
  {
    $object->repo_id = $this->id++;
    Event::fire("cataclysm.newObject", array($this, $object));

    // only store items that have been indexed, this saves memory.
    if (isset($this->used_index[$object->repo_id]))
      $this->database[$object->repo_id] = $object;
  }

  // read the data files and process them
  protected function read()
  {
    error_log("Reading data files...");
    $this->database = array();
    $it = new RecursiveDirectoryIterator(\Config::get("cataclysm.dataPath"));
    foreach(new RecursiveIteratorIterator($it) as $file) {
      $data = (array) json_decode(file_get_contents($file));
      array_walk($data, array($this, 'newObject'));
    }
    $this->newObject(json_decode('{"id":"toolset","name":"integrated toolset","type":"_SPECIAL"}'));
    $this->newObject(json_decode('{"id":"fire","name":"nearby fire","type":"_SPECIAL"}'));
  }

  // save an index to an object
  public function index($index, $key, $object)
  {
    $this->used_index[$object->repo_id] = true;
    $this->index[$index][$key] = $object->repo_id;
  }

  // return a single object
  public function get($index, $id)
  {
    $this->load();
    
    if (!isset($this->index[$index][$id]))
      return null;
    $db_id = $this->index[$index][$id];
    return $this->database[$db_id];
  }

  // return all the objects in the index
  public function all($index)
  {
    $this->load();
    
    if (!isset($this->index[$index]))
      return array();

    return $this->index[$index];
  }
}
