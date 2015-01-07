<?php

use Illuminate\Support\ServiceProvider;

class DataServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('Repositories\RepositoryInterface',
            'Repositories\CacheRepository');
    }
}
