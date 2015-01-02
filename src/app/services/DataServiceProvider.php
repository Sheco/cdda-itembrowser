<?php

use Illuminate\Support\ServiceProvider;

class DataServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('Repositories\RepositoryReaderInterface',
            'Repositories\CompiledReader');

        $this->app->singleton('Repositories\RepositoryInterface',
            'Repositories\RepositoryCache');
    }
}
