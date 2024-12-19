<?php
declare(Strict_types=1);

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;
use Symfony\Component\HttpFoundation\Request;
use Juan\ApiService\View\RoutesAction;

$routes = new RouteCollection();
$action = new RoutesAction();
$request = Request::createFromGlobals();

$routes->add('access', new Route('/app/v01/login', ['_controller' => $action->login($request)]));
$routes->add('state', new Route('/app/v01/action', ['_controller' => $action->hook($request)]));
$routes->add('send', new Route('/app/v01/send', ['_controller' => $action->handle($request)]));

return $routes;

?>