<?php

class RecipePresenter extends Robbo\Presenter\Presenter
{
  public function presentTime()
  {
    $time = $this->object->time;
    if($time>=1000)
      return ($time/1000)." minutes";
    return ($time/100)." turns";
  }

  public function presentSkillsRequired ()
  {
    $skills = $this->object->skills_required;
    if(!$skills)
      return "N/A";

    return join(", ", array_map(function($i) use ($skills) { 
            return "$i[0]($i[1])"; 
    }, $skills));
  }

  function presentTools()
  {
    $tools = array();
    foreach ($this->object->tools as $group) 
    {
      $inner = array();
      foreach ($group->items as $gi)
      {
        $inner[] =  link_to_route("item.view", $gi["item"]->name, array("id"=>$gi["item"]->id))." ". $gi["amount"];
      }
      $tools[] = join(" OR ", $inner);
    }
    return "Tools required:<br>&gt; ".join("<br>&gt; ", $tools)."\n";
  }

  function presentComponents()
  {
    $components = array();
    foreach ($this->object->components as $group)
    {
      $inner = array();
      foreach ($group->items as $gi)
      {
        $inner[] = $gi["amount"]." ". link_to_route("item.view", $gi["item"]->name, array("id"=>$gi["item"]->id));
      }
      $components[] = join(" OR ", $inner);
    }
    $label = $this->object->category=="CC_NONCRAFT"? "obtained":"required";
    return "Components $label:<br>&gt; ".join("<br>&gt; ", $components)."\n";
  }
}
