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
    $method = "get".str_replace(" ", "", ucwords(str_replace("_", " ", $name)));
    if(method_exists($this, $method))
      return $this->{$method}();
    if (isset($this->data->$name))
      return $this->data->$name;
    return "N/A";
  }

  public function getResult()
  {
    return Items::get($this->data->result);
  }

  public function getSkillsRequired ()
  {
    if(!isset($this->data->skills_required))
      return ["N/A"];

    $skills = $this->data->skills_required;
    if(!is_array($skills[0]))
      return ["$skills[0]($skills[1])"];

    return array_map(function($i) use ($skills) { 
            return "$i[0]($i[1])"; 
    }, $skills);
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
