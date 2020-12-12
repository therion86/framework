<?php

declare(strict_types=1);

namespace framework\routing;

use Aura\Router\Matcher;
use Aura\Router\RouterContainer;
use framework\DependencyInjection;
use framework\exceptions\RouteException;
use framework\interfaces\HttpResponseInterface;
use framework\interfaces\PageInterface;
use framework\interfaces\RouteRegistererInterface;
use framework\interfaces\RoutingInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use framework\request\HttpRequestFactory;
use framework\response\HttpResponse;
use framework\response\RedirectResponse;
use ReflectionClass;
use ReflectionException;

/**
 * @author Therion86
 */
class Routing implements RoutingInterface
{

    public const POST = 'post';
    public const GET = 'get';
    public const DELETE = 'delete';
    public const PUT = 'put';
    public const CSS = 'css';

    /**
     * @var Matcher[]
     */
    private array $matchingRoutes;

    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @var ResponseInterface
     */
    private $response;

    /**
     * @var DependencyInjection
     */
    private DependencyInjection $di;

    /**
     * @var string
     */
    private string $srcDir;

    /**
     * @param DependencyInjection $di
     * @param string $srcDir
     * @param RouteRegistererInterface $routeRegisterer
     * @throws ReflectionException
     * @throws RouteException
     * @author Therion86
     */
    public function __construct(
        DependencyInjection $di,
        string $srcDir,
        RouteRegistererInterface $routeRegisterer
    ) {
        // create a server request object
        $this->request = HttpRequestFactory::fromGlobals(
            $_SERVER,
            $_GET,
            $_POST,
            $_COOKIE,
            $_FILES
        );
        $this->response = new HttpResponse();
        $this->di = $di;
        $this->srcDir = $srcDir;
        $this->loadRoutes($routeRegisterer);
    }

    /**
     * @return string
     * @throws RouteException
     * @author Therion86
     */
    public function printContent(): string
    {
        $matchers = $this->matchingRoutes;
        $request = $this->request;
        $response = $this->response;
        $bodies = '';
        foreach ($matchers as $matcher) {
            $route = $matcher->match($request);
            if (!$route) {
                continue;
            }
            // add route attributes to the request
            foreach ($route->attributes as $key => $val) {
                $request = $request->withAttribute($key, $val);
            }
            $parsedBody = $request->getParsedBody();
            if (!empty($parsedBody)) {
                foreach ($parsedBody as $key => $value) {
                    $request = $request->withAttribute($key, $value);
                }
            }
            // dispatch the request to the route handler.
            // (consider using https://github.com/auraphp/Aura.Dispatcher
            // in place of the one callable below.)
            $callable = $route->handler;
            $response = $callable($request, $response);
            /* @var $response HttpResponseInterface */
            // emit the response
            foreach ($response->getHeaders() as $name => $values) {
                foreach ($values as $value) {
                    header(sprintf('%s: %s', $name, $value), false);
                }
            }
            http_response_code($response->getStatusCode());
            $bodies .= $response->getBody();
        }
        if (empty ($bodies) && ! $response instanceof RedirectResponse) {
            throw RouteException::forEmptyBody();
        }
        return $bodies;
    }

    /**
     * @param string $type
     * @param string $routeName
     * @param string $routeMap
     * @param string $factoryClassName
     * @param string $pageClassName
     * @return void
     * @throws ReflectionException
     * @throws RouteException
     * @author Therion86
     */
    private function addRoute(
        string $type,
        string $routeName,
        string $routeMap,
        string $factoryClassName,
        string $pageClassName
    ): void {
        $response = $this->response;
        // create the router container and get the routing map
        $routerContainer = new RouterContainer();
        $map = $routerContainer->getMap();
        if ('' === $pageClassName) {
            throw RouteException::forNoPageDefined($routeName);
        }
        if ('' === $factoryClassName) {
            throw RouteException::forNoFactoryDefined($routeName);
        }
        $reflection = new ReflectionClass($pageClassName);
        $createMethod = 'create' . ucfirst($reflection->getShortName());
        if (false === method_exists($factoryClassName, $createMethod)) {
            throw RouteException::forNoCreateMethodDefined($routeName, $factoryClassName, $pageClassName);
        }
        $factory = new $factoryClassName($this->di);
        $page = $factory->$createMethod();
        if ($page !== null
            && ! $page instanceof PageInterface
        ) {
            throw RouteException::forExecuteMethodNotFoundInPage($pageClassName);
        }

        switch ($type) {
            case self::POST:
                $mapMethod = self::POST;
                break;
            case self::DELETE:
                $mapMethod = self::DELETE;
                break;
            case self::PUT:
                $mapMethod = self::PUT;
                break;
            default:
                $mapMethod = self::GET;
        }

        $route = $map->$mapMethod(
            $routeName,
            $routeMap,
            function ($request) use ($page, $response) {
                return $page->execute($request, $response);
            }
        );
        if (isset($options['tokens'])) {
            $route
                ->tokens((array)$options['tokens']);
        }
        // get the route matcher from the container ...
        $this->matchingRoutes[] = $routerContainer->getMatcher();
    }

    /**
     * @param RouteRegistererInterface $routeRegisterer
     * @return void
     * @throws ReflectionException
     * @throws RouteException
     * @author Therion86
     */
    private function loadRoutes(RouteRegistererInterface $routeRegisterer): void
    {
        foreach ($routeRegisterer->getRegisteredRoutes() as $registeredRoute) {
            $routeContainer = new RouteContainer();
            $registeredRoute->addRoutes($routeContainer);
            foreach ($routeContainer->getRoutes() as $route) {
                $this->addRoute(
                    $route->getType(),
                    $route->getRouteName(),
                    $route->getRouteMap(),
                    $route->getFactoryClassName(),
                    $route->getPageClassName()
                );
            }
        }
    }
}