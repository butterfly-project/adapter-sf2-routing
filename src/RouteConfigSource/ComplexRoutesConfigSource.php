<?php

namespace Butterfly\Adapter\Sf2Routing\RouteConfigSource;

class ComplexRoutesConfigSource implements IRoutesConfigSource
{
    /**
     * @var IRoutesConfigSource[]
     */
    protected $sources = array();

    /**
     * @param IRoutesConfigSource[] $routesConfigSources
     */
    public function __construct(array $routesConfigSources = array())
    {
        foreach ($routesConfigSources as $routesConfigSource) {
            $this->addRoutesConfigSource($routesConfigSource);
        }
    }

    /**
     * @param IRoutesConfigSource $routeSource
     */
    public function addRoutesConfigSource(IRoutesConfigSource $routeSource)
    {
        $this->sources[] = $routeSource;
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        $config = array();

        foreach ($this->sources as $source) {
            $config = array_merge($config, $source->getConfig());
        }

        return $config;
    }
}
