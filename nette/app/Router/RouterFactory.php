<?php

declare(strict_types=1);

namespace App\Router;

use Nette;
use Nette\Application\Routers\RouteList;


final class RouterFactory
{
	use Nette\StaticClass;

	public static function createRouter(): RouteList
	{
		$router = new RouteList;
		$router->addRoute('/module', 'ModuleTest:Test:default');
		$router->addRoute('/test', 'Homepage:test');
		$router->addRoute('/metrics', 'Homepage:metrics');
		$router->addRoute('/detail/<id>', 'Homepage:detail');
		$router->addRoute('<presenter>/<action>[/<id>]', 'Homepage:default');
		return $router;
	}
}
