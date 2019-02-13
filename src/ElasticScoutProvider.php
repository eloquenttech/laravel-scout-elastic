<?php

namespace Eloquent\ElasticScout;

use Laravel\Scout\EngineManager;
use Illuminate\Support\ServiceProvider;
use Elasticsearch\ClientBuilder as ElasticBuilder;

class ElasticScoutProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        resolve(EngineManager::class)->extend('elastic', function () {
            return new ElasticScoutEngine(
                ElasticBuilder::create()
                    ->setHosts(config('scout.elastic.hosts'))
                    ->build()
            );
        });
    }
}
