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
        $router->addRoute('login', 'User:login');
        $router->addRoute('Login', 'User:login');
        $router->addRoute('register', 'User:register');
        $router->addRoute('Register', 'User:register');
        $router->addRoute('lorem', 'Lorem:default');
        $router->addRoute('Lorem', 'Lorem:default');
        $router->addRoute('logout', 'User:logout');
        $router->addRoute('Logout', 'User:logout');
        return $router;
	}
}
