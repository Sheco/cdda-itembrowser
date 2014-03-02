<?php

class MaterialRepository implements MaterialRepositoryInterface
{
  protected $database;
  protected $config;

  public function __construct(Config $config)
  {
    $this->parse();
    $this->config = $config;
  }

  public function find($id)
  {
    $material = App::make('Material');
    if(isset($this->database[$id]))
      $material->load($this->database[$id]);
    return $material;
  }

  public function where($text)
  {
    throw new Exception(); // not implemented
  }

  protected function parse()
  {
    $this->database = $this->read();
  }

  protected function read()
  {
    error_log("reading materials...");

    $items = array();
    
    $path = $this->config->get("cataclysm.dataPath");
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
