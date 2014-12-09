<?php

class Monster implements Robbo\Presenter\PresentableInterface
{
  use MagicModel;

  protected $data;

  public function load($data)
  {
    $this->data = $data;
  }  

  public function getPresenter()
  {
    return new Presenters\Monster($this);
  }
}

