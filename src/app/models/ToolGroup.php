<?php

class ToolGroup
{
  public $items;
  public function __construct($data)
  {
    $item = App::make('ItemRepositoryInterface');
     array_walk($data, function(&$i) use ($item) {
        $i = array(
          "item"=>$item->find($i[0]),
          "amount"=>$i[1]>1? " ($i[1] charges) ": ""
        );
    });
    $this->items = $data;
  }
}

