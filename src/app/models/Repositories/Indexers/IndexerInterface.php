<?php
namespace Repositories\Indexers;

use Repositories\RepositoryWriterInterface;

interface IndexerInterface
{
    public function onNewObject(RepositoryWriterInterface $repo, $object);
    public function onFinishedLoading(RepositoryWriterInterface $repo);
}
