<?php

class Monster implements Robbo\Presenter\PresentableInterface
{
    use MagicModel;

    protected $data;

    public function load($data)
    {
        $this->data = $data;
    }

    public function getPresenter()
    {
        return new Presenters\Monster($this);
    }

    public function getMinDamage()
    {
        return $this->melee_dice+$this->melee_cut;
    }

    public function getMaxDamage()
    {
        return ($this->melee_dice*$this->melee_dice_sides)+$this->melee_cut;
    }

    public function getAvgDamage()
    {
        return ($this->minDamage+$this->maxDamage)/2;
    }

    public function getSpecies()
    {
        return (array) $this->data->species;
    }

    public function getFlags()
    {
        return (array) $this->data->flags;
    }

    public function getId()
    {
        return $this->data->id;
    }
}
