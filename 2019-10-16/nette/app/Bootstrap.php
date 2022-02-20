<?php

declare(strict_types=1);

namespace App;

use Nette\Configurator;


class Bootstrap
{
    public static function boot(): Configurator
    {
        $configurator = new Configurator;
        self::prometheus();

        $configurator->setDebugMode(true); // enable for your remote IP
        $configurator->enableTracy(__DIR__ . '/../log');

        $configurator->setTimeZone('Europe/Prague');
        $configurator->setTempDirectory(__DIR__ . '/../temp');

        $configurator->createRobotLoader()
            ->addDirectory(__DIR__)
            ->register();

        $configurator->addParameters([
            'appDir' => __DIR__,
        ]);
        $configurator->addConfig(__DIR__ . '/config/common.neon');
        $configurator->addConfig(__DIR__ . '/config/local.neon');

        return $configurator;
    }

    private static function prometheus()
    {
        \Prometheus\Storage\Redis::setDefaultOptions(
            [
                'host' => 'redis',
                'port' => 6379,
                'password' => null,
                'timeout' => 0.1, // in seconds
                'read_timeout' => 10, // in seconds
                'persistent_connections' => false
            ]
        );
    }
}
