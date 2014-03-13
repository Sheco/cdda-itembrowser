<?phP

class JsonRepository implements RepositoryInterface
{
  protected $database;
  protected $index;
  private $id;

  function __construct()
  {
    $this->id = 0;
    $this->index = array();
    $this->database = array();
  }

  // lazy load
  private function load()
  {
    if($this->database)
      return;

    $this->read();
  }

  public function index($index, $key, $object)
  {
    $this->index[$index][$key] = $object->repo_id;
  }

  private function newObject($object)
  {
    $object->repo_id = $this->id++;
    $this->database[$object->repo_id] = $object;
    Event::fire("cataclysm.newObject", array($this, $object));
  }

  protected function read()
  {
    $this->database = array();
    $it = new RecursiveDirectoryIterator(\Config::get("cataclysm.dataPath"));
    error_log("Reading data files...");
    foreach(new RecursiveIteratorIterator($it) as $file)
    {
      $data = (array) json_decode(file_get_contents($file));
      foreach($data as $object) 
      {
        $this->newObject($object);
      }
    }
    $this->newObject(json_decode('{"id":"toolset","name":"integrated toolset","type":"_SPECIAL"}'));
    $this->newObject(json_decode('{"id":"fire","name":"nearby fire","type":"_SPECIAL"}'));
  }

  // return a single object
  public function get($index, $id)
  {
    $this->load();
    
    if(!isset($this->index[$index][$id]))
      return null;
    $db_id = $this->index[$index][$id];
    return $this->database[$db_id];
  }

  // return all the objects in the index
  public function all($index)
  {
    $this->load();
    
    if(!isset($this->index[$index]))
      return array();

    return $this->index[$index];
  }
}
