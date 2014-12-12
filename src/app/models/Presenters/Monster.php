<?php
namespace Presenters;

class Monster extends \Robbo\Presenter\Presenter
{
  function presentSymbol() {
    list($fg, $bg) = colorPairToCSS($this->object->color);
    return sprintf("<span style=\"color: %s; background: %s\">%s</span>", 
      $fg, $bg,
      $this->object->symbol);
  }

  function presentNiceName() {
    return ucfirst($this->object->name);
  }

  function presentFlags() {
    return join(", ", $this->object->flags);
  }

  function presentDeathFunction() {
    $death = (array) $this->object->death_function;
    if(empty($death))
      return "";

    return join(", ", $death);
  }

  function presentSpecialAttacks() {
    $attacks = (array) $this->object->special_attacks;
    if(empty($attacks)) {
      return "";
    }

    array_walk($attacks, function(&$attack) {
      $attack = "$attack[0]: $attack[1]";
    });
    return join(",<br>", $attacks);
  }

  function presentSpecies() {
    $links = array_map(function($species) {
      return link_to_route('monster.species', $species, array($species));
    }, $this->object->species);

    return join(", ", $links);
  }

  function presentDamage() {
    return "{$this->melee_dice}d{$this->melee_dice_sides}+{$this->melee_cut}";
  }
}
