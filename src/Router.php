<?php

namespace Butterfly\Adapter\Sf2Routing;

use Butterfly\Application\RequestResponse\Routing\IRouter;
use Butterfly\Application\RequestResponse\Routing\IRouterAware;
use Butterfly\Component\DI\IInjector;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;

class Router implements IRouter, IInjector
{
    /**
     * @var RouteCollection
     */
    protected $routes;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @param RouteCollection $routes
     */
    public function __construct(RouteCollection $routes)
    {
        $this->routes = $routes;
    }

    /**
     * @param Request $request
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param Request $request
     * @return string
     */
    public function getActionCode(Request $request)
    {
        $parameters = $this->getUrlMatcher()->matchRequest($request);

        $request->attributes->set('_route_params', $parameters);
        foreach ($parameters as $name => $value) {
            $request->attributes->set($name, $value);
        }

        return $parameters['_controller'];
    }

    /**
     * @return UrlMatcher
     */
    protected function getUrlMatcher()
    {
        $context = $this->getRequestContext();

        return new UrlMatcher($this->routes, $context);
    }

    /**
     * @param string $route
     * @param array  $parameters
     * @param bool   $isAbsolute
     * @return string The generated URL
     */
    public function generateUrl($route, array $parameters = array(), $isAbsolute = true)
    {
        return $this->getUrlGenerator()->generate($route, $parameters, $isAbsolute);
    }

    /**
     * @return UrlGenerator
     */
    protected function getUrlGenerator()
    {
        $context = $this->getRequestContext();

        return new UrlGenerator($this->routes, $context);
    }

    /**
     * @return RequestContext
     */
    protected function getRequestContext()
    {
        $context = new RequestContext();
        $context->fromRequest($this->request);

        return $context;
    }

    /**
     * @param Object $object
     */
    public function inject($object)
    {
        if ($object instanceof IRouterAware) {
            $object->setRouter($this);
        }
    }
}
