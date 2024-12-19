<?php
require __DIR__.'/bootstrap.php';

const APP_DIRECTORY = __DIR__;

use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class AppKernel
{
    private $router;

    public function __construct($router)
    {
        $this->router = $router;
    }

    public function handle(Request $request): JsonResponse
    {
        try {
            $context = new RequestContext();
            $context->fromRequest($request);
            $matcher = new UrlMatcher($this->router, $context);

            $parameters = $matcher->match($request->getPathInfo());
            $controller = $parameters['_controller'];
            $response = new JsonResponse($controller);
            $response->setStatusCode($controller['status']);
        } catch (\Exception $exception) {
            $response = new JsonResponse([
                'result' => $exception->getMessage(),
                'status' => $exception->getCode() ?: 500
            ]);
        }

        return $response;
    }
}

$router = include __DIR__.'/config/routes.php';
$appkernel = new AppKernel($router);
$request = Request::createFromGlobals();
$response = $appkernel->handle($request);
$response->send();

?>