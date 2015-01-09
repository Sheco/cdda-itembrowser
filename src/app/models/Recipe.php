<?php

class Recipe implements Robbo\Presenter\PresentableInterface
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

    public function getSkillsRequired()
    {
        if (!isset($this->data->skills_required)) {
            return;
        }

        $skills = $this->data->skills_required;
        if (!isset($skills[0])) {
            return array();
        }
        if (!is_array($skills[0])) {
            return array($skills);
        }

        return array_map(function ($i) use ($skills) {
            return $i;
        }, $skills);
    }

    public function getResult()
    {
        return $this->repo->getModel("Item", $this->data->result);
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
        return array_map(function ($group) {
            return array_map(function ($tool) {
                list($id, $amount) = $tool;

                return array($this->repo->getModel("Item", $id), $amount);
            }, $group);
        }, $this->data->tools);
    }

    public function getComponents()
    {
        return array_map(function ($group) {
            return array_map(function ($component) {
                list($id, $amount) = $component;

                return array($this->repo->getModel("Item", $id), $amount);
            }, $group);
        }, $this->data->components);
    }

    public function getCanBeLearned()
    {
        return !empty($this->data->book_learn);
    }

    public function getBooksTeaching()
    {
        return array_map(function ($book) {
            return array($this->repo->getModel("Item", $book[0]), $book[1]);
        }, $this->data->book_learn);
    }

    public function getHasQualities()
    {
        return !empty($this->data->qualities);
    }

    public function getQualities()
    {
        return array_map(function ($quality) {
            return array(
                "quality" => $this->repo->getModel("Quality", $quality->id),
                "level" => $quality->level,
                "amount" => $quality->amount,
            );
        }, $this->data->qualities);
    }

    public function getPresenter()
    {
        return new Presenters\Recipe($this);
    }

    public function getId() 
    {
        return $this->data->repo_id;
    }
}
