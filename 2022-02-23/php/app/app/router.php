<?php

require __DIR__ . '/../vendor/autoload.php';

function route(string $url, callable $request)
{
    if ((string)$_SERVER['REQUEST_URI'] === $url) {

        $registry = getPromRegistry();
        $labels = [
            'method',
            'status_code',
            'route',
        ];
        $buckets = [
            0.010,
            0.025,
            0.050,
            0.100,
            0.250,
            0.500,
            1.000,
            2.500,
            5.000,
            10.000
        ];
        $histogram = $registry->getOrRegisterHistogram('', 'http_request_duration_seconds', 'HTTP request info histogram', $labels, $buckets);

        $startTime = hrtime(true);
        $request();
        $durationNs = hrtime(true) - $startTime;

        $duration = $durationNs * 1e-9;
        $code = http_response_code();

        $histogram->observe($duration, [
            'method' => 'GET',
            'status_code' => $code,
            'route' => $url,
        ]);
    }
}

function getPromRegistry(): \Prometheus\CollectorRegistry
{
    $redisStorage = new \Prometheus\Storage\Redis(
        [
            'host' => 'redis',
            'port' => 6379,
            'password' => null,
            'timeout' => 0.1, // in seconds
            'read_timeout' => '10', // in seconds
            'persistent_connections' => false
        ]
    );

    return new \Prometheus\CollectorRegistry($redisStorage);
}
