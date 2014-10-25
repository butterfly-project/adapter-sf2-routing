<?php

namespace Butterfly\Adapter\Sf2Routing;

use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class RouteFactory
{
    /**
     * @param array $configuration
     * @return RouteCollection
     */
    public function createCollection(array $configuration)
    {
        $routes = new RouteCollection();

        foreach ($configuration as $routeName => $routeConfig) {
            $routes->add($routeName, $this->createRoute($routeConfig));
        }

        return $routes;
    }

    /**
     * @param array $config
     * @return Route
     */
    public function createRoute(array $config)
    {
        return new Route(
            isset($config['path']) ? $config['path'] : $config['pattern'],
            isset($config['defaults']) ? $config['defaults'] : array(),
            isset($config['requirements']) ? $config['requirements'] : array(),
            isset($config['options']) ? $config['options'] : array(),
            isset($config['host']) ? $config['host'] : '',
            isset($config['schemes']) ? $config['schemes'] : array(),
            isset($config['methods']) ? $config['methods'] : array()
        );

    }
}
