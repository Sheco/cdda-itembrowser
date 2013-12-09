<?php

class Recipe
{
  private $data;
  public function __construct($data)
  {
    $this->data = $data;
  }

  public function __get($name)
  {
    $method = "get".ucfirst($name);
    if(method_exists($this, $method))
      return $this->{$method}();
    return $this->data->$name;
  }

  public function getSkills_required ()
  {
    return isset($this->data->skills_required)? 
      is_array($this->data->skills_required[0])? 
        array_map(function($i) { return "$i[0]($i[1])"; }, $this->data->skills_required): 
        array("{$this->data->skills_required[0]}({$this->data->skills_required[1]})"):
      array("N/A");
  }

  public function getTime()
  {
    $time = $this->data->time;
    if($time>=1000)
      return ($time/1000)." minutes";
    return ($time/100)." turns";
  }

  public function getHasTools()
  {
    return isset($this->data->tools);
  }

  public function getHasComponents()
  {
    return isset($this->data->components);
  }

  public function getTools()
  {
    return array_map(function($group) {
        return new ToolGroup($group);}, 
        $this->data->tools);
  }

  public function getComponents()
  {
    return array_map(function($group) {
        return new ComponentGroup($group);}, 
        $this->data->components);
  }

}
