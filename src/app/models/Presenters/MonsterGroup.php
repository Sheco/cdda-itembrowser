<?php
namespace Presenters;

class MonsterGroup extends \Robbo\Presenter\Presenter
{
  function presentNiceName() {
    return ucfirst(strtolower(substr($this->object->name,6)));
  }

  function presentUniqueMonsters() {
    $monsters = $this->object->uniqueMonsters;
    array_walk($monsters, function(&$monster) {
      $monster = new Monster($monster);
    });
    usort($monsters, function($a, $b) {
      return strcmp(strtolower($a->name), strtolower($b->name));
    });
    return $monsters;
  }
}
