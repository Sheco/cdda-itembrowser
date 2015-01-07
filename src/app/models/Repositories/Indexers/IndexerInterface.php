<?php
namespace Repositories\Indexers;

use Repositories\LocalRepository;

interface IndexerInterface
{
    public function onNewObject(LocalRepository $repo, $object);
    public function onFinishedLoading(LocalRepository $repo);
}
