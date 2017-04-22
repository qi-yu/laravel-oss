<?php

namespace Moonlight\Laravel\AliyunOSS;

use function foo\func;
use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;


class AliyunOSSServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('oss', function($app) {
            $config = $app->make('config')->get('filesystems.disks');
            $config = Arr::where($config, function($item) {
                return $item['driver'] === 'oss';
            });

            return new AliyunOSSManager($config);
        });

        $this->app->bind('oss.adapter', function($app) {
            return $app['oss']->adapter();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['oss', 'oss.adapter'];
    }

}