<?php

class Quality implements Robbo\Presenter\PresentableInterface
{
    use MagicModel;

    protected $data;

    public function load($data)
    {
        $data->name = str_replace(" quality", "", $data->name);
        $this->data = $data;
    }

    public function getPresenter()
    {
        return new Presenters\Quality($this);
    }

    public function getId()
    {
        return $this->data->id;
    }
}
