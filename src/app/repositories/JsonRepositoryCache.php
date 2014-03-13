<?php 

class JsonRepositoryCache extends JsonRepository implements RepositoryInterface
{
  const CACHE_KEY="json_data";
  protected function read()
  {
    $data = Cache::remember(self::CACHE_KEY, 60, function () {
      parent::read();
      return array($this->database, $this->index);
    });
    list($this->database, $this->index) = $data;
  }

}
