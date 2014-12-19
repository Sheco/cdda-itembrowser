<?php

class Item implements Robbo\Presenter\PresentableInterface
{
  use MagicModel;

  protected $data;
  protected $repo;

  private $cut_pairs = array(
      "cotton"=>"rag",
      "leather"=>"leather",
      "nomex"=>"nomex",
      "plastic"=>"plastic_chunk",
      "kevlar"=>"kevlar_plate",
      "wood"=>"skewer"
    );

  public function __construct(Repositories\RepositoryInterface $repo)
  {
    $this->repo = $repo;
  }

  public function load($data)
  {
    if (!isset($data->material))
      $data->material = array( "null", "null" );
    if (!is_array($data->material))
      $data->material = array($data->material, "null");
    if (!isset($data->material[1]))
      $data->material[1] = "null";

    if(!isset($data->flags))
      $data->flags = array();
    else {
      if(isset($data->flags[0])) {
        $data->flags = array_flip((array) $data->flags);
      }
    }
    if(!isset($data->qualities))
      $data->qualities = array();

    $this->data = $data;
  }

  public function loadDefault($id)
  {
    $data = json_decode('{"id":"'.$id.'","name":"'.$id.'?","type":"invalid"}');
    $this->load($data);
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
    return $this->repo->allObjects("Recipe", "item.recipes.{$this->data->id}");
  }

  public function getDisassembly()
  {
    return $this->repo->allObjects("Recipe", "item.disassembly.{$this->id}");
  }

  public function getDisassembledFrom()
  {
    return $this->repo->allObjects("Recipe", "item.disassembledFrom.$this->id");
  }

  public function getToolFor()
  {
    return $this->repo->allObjects("Item", "item.toolFor.$this->id");
  }

  public function count($type)
  {
    $counts = $this->repo->all("item.count.$this->id");
    return $counts[$type];
  }

  public function getToolCategories()
  {
    $categories = $this->repo->all("item.categories.{$this->id}");
    if(empty($categories))
      return array("CC_NONE"=>"CC_NONE");
    return $categories;
  }

  public function getToolForCategory($category)
  {
    return $this->repo->allObjects("Recipe", "item.toolForCategory.{$this->data->id}.$category");
  }

  public function getLearn()
  {
    return $this->repo->allObjects("Recipe", "item.learn.{$this->data->id}");
  }

  public function getIsArmor()
  {
    return $this->data->type=="ARMOR";
  }

  public function getIsConsumable()
  {
    return $this->data->type=="COMESTIBLE";
  }

  public function getIsAmmo()
  {
    return $this->data->type == "AMMO";
  }

  public function getIsBook()
  {
    return $this->data->type == "BOOK";
  }

  public function getIsGun()
  {
    return $this->data->type == "GUN";
  }

  public function protection($type)
  {
    $mat1 = $this->material1;
    $mat2 = $this->material2;

    $variable = "{$type}_resist";
    $thickness = $this->material_thickness;
    if($thickness<1) $thickness=1;
    if ($mat2=="null") {
      return $thickness*3*$mat1->$variable;
    } else {
      return $thickness*(($mat1->$variable*2)+$mat2->$variable);
    }
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

  public function getPierce()
  {
    return isset($this->data->pierce)? $this->data->pierce: 0;
  }

  public function getMaterial1()
  {
    return $this->repo->getObject("Material", $this->data->material[0]);
  }

  public function getMaterial2()
  {
    return $this->repo->getObject("Material", $this->data->material[1]);
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
    return array($this->volume*$count, $this->repo->getObject("Item", $this->cut_pairs[$material]));
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

  public function getAmmoTypes()
  {
    return $this->repo->allObjects("Item", "ammo.$this->ammo");
  }

  public function isMadeOf($material)
  {
    return stristr($this->material1->name,$material);
  }

  public function matches($text)
  {
    $text = trim($text);

    if($text=="") return false;

     return $this->symbol==$text || 
        stristr($this->id, $text) || 
        stristr($this->name, $text);
  }

  public function getPresenter()
  {
    return new Presenters\Item($this);
  }

  public function hasFlag($flag)
  {
    return isset($this->flags[$flag]);
  }

  public function getQualities()
  {
    return array_map(function ($quality) {
      return array(
        "quality"=>$this->repo->getObject("Quality", $quality[0]),
        "level"=>$quality[1]
      );
    }, $this->data->qualities);
  }

  public function qualityLevel($quality)
  {
    foreach ($this->data->qualities as $q) {
      if($q[0]==$quality) {
        return $q[1];
      }
    }
  }

  public function getSlug()
  {
    return str_replace(" ", "_", $this->data->name);
  }

  public function noise($ammo)
  {
    if(!$this->isGun)
      return 0;

    if(in_array($ammo->ammo_type, array('bolt', 'arrow', 'pebble', 'fishspear', 'dart')))
      return 0;

    $ret = $ammo->damage;
    $ret *= 0.8;
    if($ret>5) $ret+=20;
    $ret *= 1.5;
    return $ret;
  }

  public function getMaterials() 
  {
    $materials = array(
      $this->material1, 
    );
    if ($this->material2->ident!="null") 
      $materials[] = $this->material2;
    return $materials;
  }

  public function getHasFlags()
  {
    return count($this->flags)>0;
  }

  public function getDamagePerMove() 
  {
    return number_format(($this->bashing+$this->cutting)/$this->movesPerAttack,2);
  }

  public function getIsModdable() 
  {
    return count($this->valid_mod_locations)>0;
  }

  public function getIsGunMod() 
  {
    return $this->type=="GUNMOD";
  }

  public function getModGuns() 
  {
    return $this->repo->allObjects("Item", "gunmodGuns.{$this->data->id}");
  }
}
