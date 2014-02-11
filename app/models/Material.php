<?php

class Material extends MaterialRepository
{
  protected $data;

  public function load($data)
  {
    $this->data = $data;
  }  

  public function __get($name)
  {
    $method = "get".str_replace(" ", "", ucwords(str_replace("_", " ", $name)));
    if(method_exists($this, $method))
    {
      return $this->$method();
    }
    if(isset($this->data->{$name}))
      return $this->data->{$name};
    return "N/A";
  }
}

