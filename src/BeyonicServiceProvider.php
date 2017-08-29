<?php

namespace FannyPack\Beyonic;

use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

class BeyonicServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/config/beyonic.php' => config_path('beyonic.php'),
            ], 'beyonic-config');
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(BeyonicProcessor::class, function($app){
            return new BeyonicProcessor(new Client(
                [
                    'headers' => [
                        'Authorization' => 'Token ' . $app['config']['beyonic.apiKey'],
                        'Content-Type' => 'application/json'
                    ],
                    'verify' => false
                ]
            ), $app);
        });
    }
    
    public function provides()
    {
        return [BeyonicProcessor::class];
    }
}
