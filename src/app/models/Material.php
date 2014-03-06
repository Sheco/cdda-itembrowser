<?php

class Material implements Robbo\Presenter\PresentableInterface
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
    return null;
  }

  public function getPresenter()
  {
    return new MaterialPresenter($this);
  }
}

