<?php

class Item
{
  private $data;
  public function __construct($data)
  {
    if(!isset($data->material))
      $data->material = [ "null", "null" ];
    if(!is_array($data->material))
      $data->material = [$data->material, "null"];
    if(!isset($data->material[1]))
      $data->material[1] = "null";

    $this->data = $data;
  }

  function getSymbol()
  {
    if(isset($this->data->symbol))
      return $this->data->symbol;

    return " ";

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


  public function getPrettyName()
  { 
    if($this->symbol==" ")
      $symbol = "&nbsp;";
    else
      $symbol = htmlentities($this->symbol);
    return <<<EOF
    <span style="color: $this->color">
    $symbol $this->name
    </span>
EOF;
  }

  public function getRecipes()
  {
    if(!isset($this->data->recipes))
      return [];

    return array_map(function($recipe)
        { return Recipes::get($recipe); }
    , $this->data->recipes);
  }

  public function getToolFor()
  {
    if(!isset($this->data->toolFor))
      return [];
    return array_map(function($recipe)
        { return Recipes::get($recipe); }
    , $this->data->toolFor);
  }

  public function getIsArmor()
  {
    return isset($this->data->covers);
  }

  public function protection($type)
  {
    $mat1 = $this->material1;
    $mat2 = $this->material2;

    $variable = "{$type}_resist";
    $thickness = $this->material_thickness;
    if($mat2=="null")
    {
      return $thickness*3*$mat1->$variable;
    }
    else
    {
      return $thickness*(($mat1->$variable*2)+$mat2->$variable);
    }
  }

  public function getVolume()
  {
    if(!isset($this->data->volume))
      return "N/A";
    return $this->data->volume;
  }

  public function getWeight()
  {
    if(!isset($this->data->weight))
      return "N/A";
    $weight = $this->data->weight;
    return number_format($weight/1000, 2)."kg/".number_format($weight/453.6,2)."lbs";
  }

  public function getMovesPerAttack()
  {
    if(!isset($this->data->weight) || !isset($this->data->volume))
      return "N/A";
    return ceil(65 + 4 * $this->data->volume + $this->data->weight / 60);
  }

  public function getToHit()
  {
    if(!isset($this->data->to_hit))
      return "N/A";
    return sprintf("%+d", $this->data->to_hit);
  }

  public function getMaterial1()
  {
    return Materials::get($this->data->material[0]);
  }

  public function getMaterial2()
  {
    return Materials::get($this->data->material[1]);
  }
}
