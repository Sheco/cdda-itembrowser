<?php
namespace Repositories;

use Illuminate\Database\Eloquent\ModelNotFoundException;

class Repository implements RepositoryInterface
{
    protected $reader;
    protected $loaded;

    public function __construct(RepositoryReaderInterface $reader)
    {
        $this->reader = $reader;
        $this->loaded = false;
    }

    // lazy load
    private function load()
    {
        if ($this->loaded) {
            return;
        }

        $this->reader->read();
        $this->loaded = true;
    }

    // return a single raw entry
    public function get($index, $id)
    {
        $this->load();

        return $this->reader->get($index, $id);
    }

    // return all raw entries in the index
    public function all($index)
    {
        $this->load();

        return $this->reader->all($index);
    }

    public function getObjectOrFail($repo, $id)
    {
        $repo = \App::make("Repositories\\Indexers\\$repo");

        $data = $this->get($repo::DEFAULT_INDEX, $id);
        if (!$data) {
            throw new ModelNotFoundException();
        }

        $model = $repo->model();
        $model->load($data);

        return $model;
    }

    public function getObject($repo, $id)
    {
        $repo = \App::make("Repositories\\Indexers\\$repo");

        $data = $this->get($repo::DEFAULT_INDEX, $id);

        $model = $repo->model();

        if (!$data) {
            $model->loadDefault($id);
        } else {
            $model->load($data);
        }

        return $model;
    }

    public function allObjects($repo, $index = null)
    {
        if (!$index) {
            $repoInstance = \App::make("Repositories\\Indexers\\$repo");
            $index = $repoInstance::DEFAULT_INDEX;
        }

        $data = $this->all($index);

        array_walk($data, 
            function (&$value, $key) use ($repo) {
                $value = $this->getObject($repo, $key);
            }
        );

        return $data;
    }

    public function searchObjects($repo, $search)
    {
        \Log::info("searching for $search...");

        $results = array();
        if (!$search) {
            return $results;
        }

        foreach ($this->allObjects($repo) as $obj) {
            if ($obj->matches($search)) {
                $results[] = $obj;
            }
        }

        return $results;
    }

    public function version()
    {
        return $this->reader->version();
    }
}
