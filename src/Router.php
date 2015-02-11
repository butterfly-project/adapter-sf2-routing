<?php

namespace Butterfly\Adapter\Sf2Routing;

use Butterfly\Application\RequestResponse\Routing\IRouter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcher;

/**
 * @author Marat Fakhertdinov <marat.fakhertdinov@gmail.com>
 */
class Router implements IRouter
{
    /**
     * @var UrlMatcher
     */
    protected $urlMatcher;

    /**
     * @param UrlMatcher $urlMatcher
     */
    public function __construct(UrlMatcher $urlMatcher)
    {
        $this->urlMatcher = $urlMatcher;
    }

    /**
     * @param Request $request
     * @return string
     */
    public function getAction(Request $request)
    {
        try {
            $matchResult = $this->urlMatcher->matchRequest($request);
        } catch (ResourceNotFoundException $e) {
            return null;
        }

        $parameters = array($request);

        $request->attributes->set('_route_params', $matchResult);
        foreach ($matchResult as $name => $value) {
            $request->attributes->set($name, $value);
        }

        return array($matchResult['_controller'], $parameters);
    }
}
