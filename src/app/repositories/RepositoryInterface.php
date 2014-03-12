<?php

interface RepositoryInterface 
{
  public function registerIndexer(IndexerInterface $indexer);
  public function get($index, $id);
  public function all($index);
}
