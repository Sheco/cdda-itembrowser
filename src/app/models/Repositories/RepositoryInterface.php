<?php
namespace Repositories;

interface RepositoryInterface
{
    public function get($index, $id);
    public function getObjectOrFail($repo, $id);
    public function getObject($repo, $id);

    public function all($index);
    public function allObjects($repo, $index = null);

    public function searchObjects($repo, $search);

    public function version();
}
