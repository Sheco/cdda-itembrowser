<?php

class ItemPresenter extends Robbo\Presenter\Presenter
{
  function presentSymbol()
  {
    $symbol = $this->object->symbol;
    if($symbol==" ")
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
    if($weight===null)
      return null;
    return number_format($weight/1000, 2)."kg/".number_format($weight/453.6,2)."lbs";
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
    return array_map(function($recipe)
        { return new RecipePresenter($recipe); }
    , $this->object->recipes);
  }

  public function presentDisassembly()
  {
    return array_map(function($recipe)
        { return new RecipePresenter($recipe); }
    , $this->object->disassembly);
  }


  public function presentMaterials()
  {
    $materials = array(
      $this->object->material1->name, 
    );
    if($this->object->material2->ident!="null") 
      $materials[] = $this->object->material2->name;
    $open = '';
    $close = '';
    return $open.join("$close, $open", $materials).$close;
  }

  public function presentFeatureLabels()
  {
    $badges = array();
    $recipes = count($this->toolFor);
    if($recipes)
      $badges[] = '<span class="label label-success">recipes: '.$recipes.'</span>';
    if(count($this->disassembly))
      $badges[] = '<span class="label label-info">disassemble</span>';
    if(count($this->recipes)) 
      $badges[] = '<span class="label label-default">craft</span>';
    return join(" ", $badges);
  }

  public function presentCutResult()
  {
    $cutresult = $this->object->cutResult;
    return $cutresult[0]." ".str_plural($cutresult[1]->name);
  }

  public function presentCraftingRecipes()
  {
    $recipes = array();
    foreach($this->object->craftingRecipes as $recipe)
    {
      $recipes[] = link_to_route('item.view', $recipe->result->name, $recipe->result->id); 
    }
    return join(", ", $recipes);
  }

  public function presentCovers()
  {
    return join(", ", $this->object->covers);
  }

}
