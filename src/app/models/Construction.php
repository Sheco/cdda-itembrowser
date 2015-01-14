<?php

class Construction implements Robbo\Presenter\PresentableInterface
{
    use MagicModel;

    protected $data;
    protected $repo;

    public function __construct(Repositories\RepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function load($data)
    {
        $this->data = $data;
        if($this->requiresQualities)
        foreach($data->qualities as $group) {
            foreach($group as &$q) {
                $q->quality = $this->repo->getModel("Quality", $q->id);
            }
        }
        if($this->requiresTools)
        foreach($data->tools as &$group) {
            foreach($group as $k=>$v) {
                $charges = 0;
                if(is_array($v))
                    list($v, $charges) = $v;
                $group[$k] = (object) array(
                    "item"=>$this->repo->getModel("Item", $v),
                    "charges"=>$charges,
                );
            }
        }

        if($this->requiresComponents)
        foreach($data->components as &$group)
        {
            foreach($group as $k=>$c) {
                list($id, $amount) = $c;
                $group[$k] = (object) array(
                    "amount"=>$amount,
                    "item"=> $this->repo->getModel("Item", $id)
                );
            }
        }
    }

    public function getPresenter()
    {
        return new Presenters\Construction($this);
    }

    public function getId() 
    {
        return $this->data->repo_id;
    }
    
    public function getComment()
    {
        if(!isset($this->data->{"//"}))
            return "";
        return $this->data->{"//"};
    }

    public function getRequiresQualities()
    {
        return isset($this->data->qualities);
    }

    public function getRequiresComponents()
    {
        return isset($this->data->components);
    }

    public function getRequiresTools()
    {
        return isset($this->data->tools);
    }

    public function getSkill()
    {
        return isset($this->data->skill)?$this->data->skill:"construction";
    }

    public function getHasPreTerrain()
    {
        return isset($this->data->pre_terrain);
    }

    public function getPreTerrain()
    {
        return $this->repo->getModelAuto($this->data->pre_terrain);
    }

    public function getHasPostTerrain()
    {
        return isset($this->data->post_terrain);
    }

    public function getPostTerrain()
    {
        return $this->repo->getModelAuto($this->data->post_terrain);
    }
}

