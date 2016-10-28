<?php

namespace Butterfly\Adapter\Sf2Routing\Twig;

use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * @author Marat Fakhertdinov <marat.fakhertdinov@gmail.com>
 */
class UrlGeneratorTwigExtension extends \Twig_Extension
{
    /**
     * @var UrlGenerator
     */
    protected $urGenerator;

    /**
     * @param UrlGenerator $urGenerator
     */
    public function __construct(UrlGenerator $urGenerator)
    {
        $this->urGenerator = $urGenerator;
    }

    /**
     * Returns a list of functions to add to the existing list.
     *
     * @return array An array of functions
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('url', array($this, 'generateUrl')),
            new \Twig_SimpleFunction('path', array($this, 'generatePath')),
        );
    }

    /**
     * @param string $route
     * @param array $parameters
     * @return string
     */
    public function generateUrl($route, $parameters = array())
    {
        return $this->urGenerator->generate($route, $parameters, UrlGeneratorInterface::ABSOLUTE_URL);
    }

    /**
     * @param string $route
     * @param array $parameters
     * @return string
     */
    public function generatePath($route, $parameters = array())
    {
        return $this->urGenerator->generate($route, $parameters);
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'url_generator.extension';
    }
}
