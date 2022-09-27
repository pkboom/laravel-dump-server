<?php

namespace Pkboom\DumpServer;

use Illuminate\Support\ServiceProvider;
use Symfony\Component\VarDumper\Dumper\ContextProvider\SourceContextProvider;
use Symfony\Component\VarDumper\Server\Connection;
use Symfony\Component\VarDumper\VarDumper;

class DumpServerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                DumpServerCommand::class,
            ]);
        }

        $this->publishes([
            __DIR__.'/../config/dump-server.php' => config_path('dump-server.php'),
        ], 'config');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/dump-server.php', 'dump-server');

        $host = $this->app['config']->get('dump-server.host');

        $connection = new Connection($host, [
            'request' => new RequestContextProvider($this->app['request']),
            'source' => new SourceContextProvider('utf-8', base_path()),
        ]);

        VarDumper::setHandler(function ($var) use ($connection) {
            $this->app->make(Dumper::class, ['connection' => $connection])->dump($var);
        });
    }
}
