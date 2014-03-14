<?php

class Item implements Robbo\Presenter\PresentableInterface
{
  protected $data;
  protected $recipe;
  protected $item;
  protected $material;

  private $cut_pairs = array(
      "cotton"=>"rag",
      "leather"=>"leather",
      "nomex"=>"nomex",
      "plastic"=>"plastic_chunk",
      "kevlar"=>"kevlar_plate",
      "wood"=>"skewer"
    );

  public function __construct(
    Repositories\Recipe $recipe, 
    Repositories\Material $material, 
    Repositories\Item $item
  )
  {
    $this->recipe = $recipe;
    $this->material = $material;
    $this->item = $item;
  }

  public function load($data)
  {
    if (!isset($data->material))
      $data->material = array( "null", "null" );
    if (!is_array($data->material))
      $data->material = array($data->material, "null");
    if (!isset($data->material[1]))
      $data->material[1] = "null";

    $this->data = $data;
  }

  public function __get($name)
  {
    $method = "get".str_replace(" ", "", ucwords(str_replace("_", " ", $name)));
    if (method_exists($this, $method)) {
      return $this->$method();
    }
    if (isset($this->data->{$name}))
      return $this->data->{$name};
    return null;
  }

  public function getColor()
  {
    if (!isset($this->data->color))
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
    return $this->recipe->index("item.recipes.{$this->data->id}");
  }

  public function getDisassembly()
  {
    return $this->recipe->index("item.disassembly.{$this->id}");
  }

  public function getToolFor()
  {
    return $this->recipe->index("item.toolFor.$this->id");
  }

  public function getToolCategories()
  {
    return array_keys($this->recipe->index("item.categories.{$this->id}"));
  }

  public function getToolForCategory($category)
  {
    return $this->recipe->index("item.toolForCategory.{$this->data->id}.$category");
  }

  public function getLearn()
  {
    return $this->recipe->index("item.learn.{$this->data->id}");
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
    if ($mat2=="null") {
      return $thickness*3*$mat1->$variable;
    } else {
      return $thickness*(($mat1->$variable*2)+$mat2->$variable);
    }
  }

  public function getIsAmmo()
  {
    return $this->data->type == "AMMO";
  }

  public function getIsBook()
  {
    return $this->data->type == "BOOK";
  }

  public function getIsTool()
  {
    return isset($this->data->max_charges) and isset($this->data->ammo);
  }

  public function getStackSize()
  {
    return isset($this->data->stack_size)? $this->data->stack_size: 1;
  }

  public function getVolume()
  {
    if(!isset($this->data->volume))
      return null;
    if($this->isAmmo) {
      return round($this->data->volume/$this->stackSize);
    }
    return $this->data->volume;
  }

  public function getWeight()
  {
    if(!isset($this->data->weight))
      return null;
    if($this->isAmmo)
      return $this->data->weight*$this->data->count;
    return $this->data->weight;
  }

  public function getMovesPerAttack()
  {
    if(!isset($this->data->weight) || !isset($this->data->volume))
      return null;
    return floor(65 + 4 * $this->volume + $this->weight / 60);
  }

  public function getToHit()
  {
    if(!isset($this->data->to_hit))
      return 0;
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

  public function getCanBeCut()
  {
    if (!$this->volume) return false;
    $material = $this->material1->ident;
    return in_array($material, array_keys($this->cut_pairs));
  }

  public function getCutResult()
  {
    $material = $this->material1->ident;
    $count = $material=="wood"? 2: 1;
    return array($this->volume*$count, $this->item->find($this->cut_pairs[$material]));
  }

  public function getIsResultOfCutting()
  {
    return in_array($this->id, array_keys(array_flip($this->cut_pairs)));
  }

  public function getMaterialToCut()
  {
    $pairs = array_flip($this->cut_pairs);
    return $pairs[$this->id];
  }

  public function isMadeOf($material)
  {
    return stristr($this->material1->name,$material);
  }

  public function matches($text)
  {
    if($text=="") return false;

     return $this->symbol==$text || 
        stristr($this->id, $text) || 
        stristr($this->name, $text) ||
        $this->isMadeOf($text);

  }

  public function getPresenter()
  {
    return new Presenters\Item($this);
  }
}
