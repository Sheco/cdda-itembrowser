<?php
namespace Presenters;

class Monster extends \Robbo\Presenter\Presenter
{
  function presentNiceName() {
    return ucfirst($this->object->name);
  }

  function presentFlags() {
    return join(", ", $this->object->flags);
  }

  function presentDeathFunction() {
    if(empty($this->object->death_function))
      return "";

    return join(", ", $this->object->death_function);
  }

  function presentSpecialAttacks() {
    if(empty($this->object->special_attacks))
      return "";

    $attacks = $this->object->special_attacks;
    array_walk($attacks, function(&$attack) {
      $attack = "$attack[1]% $attack[0]";
    });
    return join(",<br>", $attacks);
  }

  function presentSpecies() {
    $links = array_map(function($species) {
      return link_to_route('monster.species', $species, array($species));
    }, $this->object->species);

    return join(", ", $links);
  }
}
