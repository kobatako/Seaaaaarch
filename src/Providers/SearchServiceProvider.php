<?php

namespace Search\Providers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\ServiceProvider;
use Search\Console\Commands\FilterGenerator;
use Search\Console\Commands\SearchableGenerator;
use Search\Searchable;

class SearchServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerMacro();
        $this->registerCommand();
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    protected function registerMacro()
    {
        Builder::macro('search', function(Searchable $search, $query = null) {
            return $search->process($this, $query);
        });
    }

    protected function registerCommand()
    {
        $this->app->singleton('make.searchable', function($app) {
            return new SearchableGenerator($app['files']);
        });
        $this->app->singleton('make.filter', function($app) {
            return new FilterGenerator($app['files']);
        });

        $this->commands([
            'make.searchable',
            'make.filter',
        ]);
    }
}
