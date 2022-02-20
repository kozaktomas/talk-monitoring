<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

if (\getenv('DD_TRACE_ENABLED') === 'true') {
	\DDTrace\Bootstrap::tracerAndIntegrations();
}



App\Bootstrap::boot()
    ->createContainer()
    ->getByType(Nette\Application\Application::class)
    ->run();
