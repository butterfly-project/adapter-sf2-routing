<?php

namespace Butterfly\Adapter\Sf2Routing\RouteConfigSource;

class SimpleRoutesConfigSource implements IRoutesConfigSource
{
    /**
     * @var array
     */
    protected $routesConfig;

    /**
     * @param array $routesConfig
     */
    public function __construct(array $routesConfig)
    {
        $this->routesConfig = $routesConfig;
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        return $this->routesConfig;
    }
}
