<?php

interface MaterialRepositoryInterface
{
  public function find($id);
  public function where($text);
}
