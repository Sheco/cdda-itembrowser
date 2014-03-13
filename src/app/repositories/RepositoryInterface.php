<?php

interface RepositoryInterface 
{
  public function get($index, $id);
  public function all($index);
}
