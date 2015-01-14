<?php

class WorldController extends BaseController
{
    private $repo;

    function __construct(Repositories\RepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function construction($id) 
    {
        $data = $this->repo->getModel("Construction", $id);
        $this->layout->nest("content", "world.construction", compact('data'));
    }

    public function constructionCategories($id=null)
    {
        $categories = $this->repo->raw("construction.categories");
        if($id === null)
            return Redirect::route(Route::currentRouteName(), array(reset($categories)));

        $data = $this->repo->allModels("Construction", "construction.category.$id");
        $this->layout->nest("content", "world.constructionCategories", 
            compact('categories', 'data', 'id'));
    }
}
