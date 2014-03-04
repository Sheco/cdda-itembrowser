<?php

class Item implements Robbo\Presenter\PresentableInterface
{
  protected $data;
  protected $recipe;
  protected $material;

  public function __construct(RecipeRepositoryInterface $recipe, MaterialRepositoryInterface $material)
  {
    $this->recipe = $recipe;
    $this->material = $material;
  }

  public function load($data)
  {
    if(!isset($data->material))
      $data->material = array( "null", "null" );
    if(!is_array($data->material))
      $data->material = array($data->material, "null");
    if(!isset($data->material[1]))
      $data->material[1] = "null";

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

  function getColor()
  {
    if(!isset($this->data->color))
      return "white";
    $color = str_replace("_", "", $this->data->color);
    $colorTable = array(
      "lightred"=>"indianred"
    );
    if(isset($colorTable[$color]))
      return $colorTable[$color];
    return $color;
  }


  public function getSymbol()
  {
    if(!isset($this->data->symbol)) return " ";
    return $this->data->symbol;
  }

  public function getName()
  {
     if(!isset($this->data->name)) return null;
     return ($this->type=="bionic"?"CBM: ":"").$this->data->name;
  }
  

  public function getRecipes()
  {
    if(!isset($this->data->recipes))
      return array();

    return array_map(function($recipe)
        { return $this->recipe->find($recipe); }
    , $this->data->recipes);
  }

  public function getDisassembly()
  {
    if(!isset($this->data->disassembly))
      return array();

    return array_map(function($recipe)
        { return $this->recipe->find($recipe); }
    , $this->data->disassembly);    
  }

  public function getToolFor()
  {
    if(!isset($this->data->toolFor))
      return array();
    return array_map(function($recipe)
        { return $this->recipe->find($recipe); }
    , $this->data->toolFor);
  }

  public function getToolCategories()
  {
    return array_keys($this->data->toolForCategory);
  }

  public function getToolForCategory($category)
  {
    if(!isset($this->data->toolForCategory[$category]))
      return array();
    return array_map(function($recipe)
        { return $this->recipe->find($recipe); }
    , $this->data->toolForCategory[$category]);    
  }

  public function getIsBook()
  {
    return count($this->learnBook)>0;
  }

  public function getIsArmor()
  {
    return isset($this->data->covers);
  }

  public function getIsComestible()
  {
    if(!isset($this->data->type))
      return false;
    return $this->data->type=="COMESTIBLE";
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

  public function getWeight()
  {
    if(!isset($this->data->weight))
      return null;
    $weight = $this->data->weight;
    return number_format($weight/1000, 2)."kg/".number_format($weight/453.6,2)."lbs";
  }

  public function getMovesPerAttack()
  {
    if(!isset($this->data->weight) || !isset($this->data->volume))
      return null;
    return ceil(65 + 4 * $this->data->volume + $this->data->weight / 60);
  }

  public function getToHit()
  {
    if(!isset($this->data->to_hit))
      return null;
    return sprintf("%+d", $this->data->to_hit);
  }

  public function getMaterial1()
  {
    return $this->material->find($this->data->material[0]);
  }

  public function getMaterial2()
  {
    return $this->material->find($this->data->material[1]);
  }

  public function matches($text)
  {
      return $this->symbol==$text || 
          stristr($this->id, $text) || 
          stristr($this->name, $text);

  }

  public function getPresenter()
  {
    return new ItemPresenter($this);
  }
}
