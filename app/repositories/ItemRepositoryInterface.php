<?php

interface ItemRepositoryInterface
{
  public function find($id);
  public function where($text);
  public function parse();
}
