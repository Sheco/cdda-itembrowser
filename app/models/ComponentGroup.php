<?php

class ComponentGroup
{
  public $items;
  public function __construct($data)
  {
    $item = App::make('ItemRepositoryInterface');
    array_walk($data, function(&$i) use ($item) {
        $i = array(
          "item"=>$item->find($i[0]),
          "amount"=>"$i[1]x  "
        );
    });
    $this->items = $data;
  }
}

