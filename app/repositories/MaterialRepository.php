<?php

class MaterialRepository implements MaterialRepositoryInterface
{
  protected $database;

  public function __construct()
  {
    $this->parse();
  }

  public function find($id)
  {
    $material = new Material();
    if(isset($this->database[$id]))
      $material->load($this->database[$id]);
    return $material;
  }

  public function where($text)
  {
    throw new Exception(); // not implemented
  }

  public function parse()
  {
    $this->database = $this->read();
  }

  protected function read()
  {
    error_log("reading materials...");

    $items = array();
    
    $path = \Config::get("cataclysm.dataPath");
    $file = "materials.json";
    {
      if($file[0]==".") continue;
      $json = (array) json_decode(file_get_contents("$path/$file"));
      foreach($json as $item)
      {
        $items[$item->ident] = $item;

      }
    }
    return $items;
  }
}
