<?php
namespace Presenters;

class Item extends \Robbo\Presenter\Presenter
{
  public function presentSymbol()
  {
    $symbol = $this->object->symbol;
    if ($symbol==" ")
      return "&nbsp;";
    return htmlspecialchars($symbol);
  }

  public function presentRawName()
  {
    return ucfirst($this->object->name);
  }

  public function presentName()
  { 
    return <<<EOF
    <span style="color: $this->color">$this->symbol {$this->object->name}</span>    
EOF;
  }

  public function presentVolume()
  {
    return $this->object->volume===null?"N/A":$this->object->volume;
  }

  public function presentWeight()
  {
    $weight = $this->object->weight;
    if ($weight===null)
      return null;
    return number_format($weight/453.6,2)." lbs";
  }

  public function presentWeightMetric()
  {
    $weight = $this->object->weight;
    if ($weight===null)
      return null;
    return number_format($weight/1000, 2).' kg';
  
  }

  public function presentBashing()
  {
    return $this->object->bashing?:"0";
  }

  public function presentCutting()
  {
    return $this->object->cutting?:"0";
  }

  public function presentToHit()
  {
    return $this->object->to_hit?:"N/A";
  }

  public function presentMovesPerAttack()
  {
    return $this->object->moves_per_attack?:"N/A";
  }

  public function presentRecipes()
  {
    return array_map(function ($recipe) { 
      return $recipe->getPresenter(); 
    }, $this->object->recipes);
  }

  public function presentDisassembly()
  {
    return array_map(function ($recipe) { 
      return $recipe->getPresenter(); 
    }, $this->object->disassembly);
  }

  public function presentMaterials() 
  {
    return join(", ", array_map(function($material) {
      return $material->name;
    }, $this->object->materials));
  }

  public function presentFeatureLabels()
  {
    $badges = array();
    if ($this->count("toolFor"))
      $badges[] = '<a href="'. route("item.recipes", $this->object->id) .'"><span class="label label-success">recipes: '.$this->count("toolFor").'</span></a>';
    if ($this->count("disassembly"))
      $badges[] = '<a href="'. route("item.disassemble", $this->object->id) .'"><span class="label label-info">disassemble</span></a>';
    if ($this->count("recipes")) 
      $badges[] = '<a href="'. route("item.craft", $this->object->id) .'"><span class="label label-default">craft</span></a>';
    return join(" ", $badges);
  }

  public function presentCutResultAmount()
  {
    $cutresult = $this->object->cutResult;
    return $cutresult[0];
  }

  public function presentCutResultItem()
  {
    $cutresult = $this->object->cutResult;
    return $cutresult[1];
  }

  public function presentCraftingRecipes()
  {
    $recipes = array();
    foreach($this->object->learn as $recipe) {
      $recipes[] = link_to_route('item.view', $recipe->result->name, $recipe->result->id); 
    }
    return join(", ", $recipes);
  }

  public function presentCovers()
  {
    if(!$this->object->covers)
      return "none";
    return join(", ", $this->object->covers);
  }

  public function presentSpoilsIn()
  {
    return number_format($this->object->spoils_in/24,2)." days";
  }

  public function presentStim()
  {
    return ($this->object->stim*5)." mins";
  }
}
