<?php

namespace Butterfly\Adapter\Sf2Routing\RouteConfigSource;

class AnnotationsRoutesConfigSource implements IRoutesConfigSource
{
    /**
     * @var array
     */
    protected $routesConfig = array();

    /**
     * @param string $controllerTagName
     * @param array $allAnnotations
     */
    public function __construct($controllerTagName, array $allAnnotations)
    {
        foreach ($allAnnotations as $class => $annotations) {
            if (!$this->isController($annotations['class'], $controllerTagName)) {
                continue;
            }

            if (empty($annotations['methods'])) {
                continue;
            }

            foreach ($annotations['methods'] as $methodName => $methodAnnotations) {
                if (empty($methodAnnotations['route\url'])) {
                    continue;
                }

                $controllerServiceName = !empty($annotations['class']['service']) ? $annotations['class']['service'] : strtolower($class);
                $routeName = $this->getRouteName($controllerServiceName, $methodName);

                $config = array(
                    'pattern' => $methodAnnotations['route\url'],
                );

                $config['defaults']     = !empty($methodAnnotations['route\defaults']) ? $methodAnnotations['route\defaults'] : array();
                $config['defaults']['_controller'] = $routeName;

                $config['requirements'] = !empty($methodAnnotations['route\requirements']) ? $methodAnnotations['route\requirements'] : null;
                $config['options']      = !empty($methodAnnotations['route\options']) ? $methodAnnotations['route\options'] : null;
                $config['host']         = !empty($methodAnnotations['route\host']) ? $methodAnnotations['route\host'] : null;
                $config['schemes']      = !empty($methodAnnotations['route\schemes']) ? $methodAnnotations['route\schemes'] : null;
                $config['methods']      = !empty($methodAnnotations['route\methods']) ? $methodAnnotations['route\methods'] : null;

                $this->routesConfig[$routeName] = $config;
            }
        }
    }

    /**
     * @param array $classAnnotations
     * @param string $controllerTagName
     * @return bool
     */
    protected function isController(array $classAnnotations, $controllerTagName)
    {
        if (!array_key_exists('service', $classAnnotations)) {
            return false;
        }

        if (!array_key_exists('tags', $classAnnotations)) {
            return false;
        }

        if (is_string($classAnnotations['tags']) && $controllerTagName == $classAnnotations['tags']) {
            return true;
        } elseif (is_array($classAnnotations['tags']) && in_array($controllerTagName, $classAnnotations['tags'])) {
            return true;
        }

        return false;
    }

    /**
     * @param string $controllerName
     * @param string $methodName
     * @return string
     */
    protected function getRouteName($controllerName, $methodName)
    {
        return implode(':', array(
            $controllerName,
            str_replace('Action', '', $methodName),
        ));
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        return $this->routesConfig;
    }
}
