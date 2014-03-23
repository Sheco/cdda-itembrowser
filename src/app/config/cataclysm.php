<?php

return array(
  "dataPath"=>storage_path().'/../Cataclysm-DDA-master/data/json',
  "sites"=>array(
    "stable"=>"cdda.estilofusion.com",
    "development"=>"cdda-trunk.estilofusion.com"
  ),
  // the object and index database will be split in chunks...
  // for memcache and apc storage, a small number is good
  // but for disk cache, it's better to avoid lots of very small files.
  // a value of 1 would create about 13000 cache entries.
  // a value of 100 would create about 300 cache entries.
  "itemsPerCache"=>100,

  "dataCacheExpiration"=>60,
  "searchCacheExpiration"=>60

);
