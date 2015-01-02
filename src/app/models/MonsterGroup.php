<?php

class MonsterGroup implements Robbo\Presenter\PresentableInterface
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
    }

    public function getPresenter()
    {
        return new Presenters\MonsterGroup($this);
    }

    public function getUniqueMonsters()
    {
        return array_map(function (&$monster) {
      return $this->repo->getObject('Monster', $monster);
    }, $this->data->uniqueMonsters);
    }
}
