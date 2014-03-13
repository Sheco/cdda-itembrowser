<?php
namespace Presenters;

class Recipe extends \Robbo\Presenter\Presenter
{
  public function presentTime()
  {
    $time = $this->object->time;
    if ($time>=1000)
      return ($time/1000)." minutes";
    return ($time/100)." turns";
  }

  public function presentSkillsRequired ()
  {
    $skills = $this->object->skills_required;
    if (!$skills)
      return "N/A";

    return join(", ", array_map(function($i) use ($skills) { 
            return "$i[0]($i[1])"; 
    }, $skills));
  }

  public function presentTools()
  {
    $tools = array();
    foreach ($this->object->tools as $group) {
      $inner = array();
      foreach ($group as $gi) {
        list($item, $amount) = $gi;
        $inner[] =  link_to_route("item.view", $item->name, array("id"=>$item->id))." ". $amount;
      }
      $tools[] = join(" OR ", $inner);
    }
    return "Tools required:<br>&gt; ".join("<br>&gt; ", $tools)."\n";
  }

  public function presentComponents()
  {
    $components = array();
    foreach ($this->object->components as $group) {
      $inner = array();
      foreach ($group as $gi) {
        list($item, $amount) = $gi;
        $inner[] = $amount." ". link_to_route("item.view", $item->name, array("id"=>$item->id));
      }
      $components[] = join(" OR ", $inner);
    }
    $label = $this->object->category=="CC_NONCRAFT"? "obtained":"required";
    return "Components $label:<br>&gt; ".join("<br>&gt; ", $components)."\n";
  }
}
