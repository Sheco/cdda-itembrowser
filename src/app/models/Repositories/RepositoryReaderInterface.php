<?php

namespace Repositories;

interface RepositoryReaderInterface 
{
  public function read($path=null);
  public function loadObject($index, $id);
  public function loadIndex($index);
  public function version();
}
