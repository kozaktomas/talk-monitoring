<?php

use Prometheus\RenderTextFormat;

require __DIR__ . '/../app/router.php';

function add(int $a, int $b): int
{
    sleep(1);
    return $a + $b;
}

route("/", function (): void {
    $a = mt_rand(1, 40);
    $b = mt_rand(1, 40);

    $redis = new Redis();
    $redis->connect('redis');
    $key = "{$a}+{$b}";
    $result = $redis->get($key);
    $status = "cached";

    if (!$result) {
        $result = add($a, $b);
        $redis->set($key, $result, 60);
        $status = "calculated";
    }

    http_response_code(200);
    echo "$a + $b = ";
    echo $result;
    echo " ({$status})";
});


// not that important part
// please ignore me
route("/links", function (): void {
    $baseUrl = "demo";
    $links = [
        ["name" => "Grafana", "link" => "http://$baseUrl:3000/"],
        ["name" => "Prometheus", "link" => "http://$baseUrl:9090/"],
        ["name" => "Alert manager", "link" => "http://$baseUrl:9093/"],
        ["name" => "Request basket", "link" => "http://$baseUrl:55555/"],
        ["name" => "redis-exporter", "link" => "http://$baseUrl:9121/metrics"],
        ["name" => "php-exporter", "link" => "http://$baseUrl:9253/metrics"],
        ["name" => "nginx-exporter", "link" => "http://$baseUrl:9113/metrics"],
        ["name" => "aws-exporter", "link" => "http://$baseUrl:9383/metrics"],
        ["name" => "domains-exporter", "link" => "http://$baseUrl:9203/metrics"],
        ["name" => "node-exporter", "link" => "http://$baseUrl:9100/metrics"],
    ];

    http_response_code(200);
    echo "<h1>Links:</h1>";
    echo "<ul>";
    foreach ($links as $link) {
        echo "<li><a href='{$link['link']}'>{$link['name']}</a></li>";
    }
    echo "</ul>";
});

route("/metrics", function (): void {
    $renderer = new RenderTextFormat();
    header("content-type: text/plain; version=0.0.4; charset=utf-8");
    http_response_code(200);
    echo $renderer->render(getPromRegistry()->getMetricFamilySamples());
});
