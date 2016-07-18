<?php

namespace Butterfly\Component\Sf2Routing\Tests\RouteConfigSource;

use Butterfly\Adapter\Sf2Routing\RouteConfigSource\AnnotationsRoutesConfigSource;

/**
 * @author Marat Fakhertdinov <marat.fakhertdinov@gmail.com>
 */
class AnnotationsRoutesConfigSourceTest extends \PHPUnit_Framework_TestCase
{
    public function testGetConfig()
    {
        $allAnnotations = array(
            'ProductController' => array(
                'class'   => array(
                    'service' => 'controller.product',
                    'tags'    => 'controllers'
                ),
                'methods' => array(
                    'indexAction' => array(
                        'route\url'          => '/products/index',
                        'route\defaults'     => array('id' => 123),
                        'route\requirements' => array('id' => '\d+'),
                        'route\options'      => array('a', 'b'),
                        'route\host'         => 'localhost',
                        'route\schemes'      => array('http', 'https'),
                        'route\methods'      => array('POST', 'GET'),
                    ),
                )
            ),
        );

        $source = new AnnotationsRoutesConfigSource('controllers', $allAnnotations);

        $expectedConfig = array(
            'controller.product:index' => array(
                'pattern'      => '/products/index',
                'defaults'     => array(
                    'id'          => 123,
                    '_controller' => 'controller.product:index',
                ),
                'requirements' => array('id' => '\d+'),
                'options'      => array('a', 'b'),
                'host'         => 'localhost',
                'schemes'      => array('http', 'https'),
                'methods'      => array('POST', 'GET'),
            )
        );

        $this->assertEquals($expectedConfig, $source->getConfig());
    }

    public function testGetConfigIfNotServiceName()
    {
        $allAnnotations = array(
            'ProductController' => array(
                'class'   => array(
                    'tags'    => 'controllers'
                ),
                'methods' => array(
                    'indexAction' => array(
                        'route\url'          => '/products/index',
                        'route\defaults'     => array('id' => 123),
                        'route\requirements' => array('id' => '\d+'),
                        'route\options'      => array('a', 'b'),
                        'route\host'         => 'localhost',
                        'route\schemes'      => array('http', 'https'),
                        'route\methods'      => array('POST', 'GET'),
                    ),
                )
            ),
        );

        $source = new AnnotationsRoutesConfigSource('controllers', $allAnnotations);

        $this->assertEquals(array(), $source->getConfig());
    }

    public function testGetConfigIfNoTags()
    {
        $allAnnotations = array(
            'ProductController' => array(
                'class'   => array(
                    'service' => 'controller.product',
                ),
                'methods' => array(
                    'indexAction' => array(
                        'route\url'          => '/products/index',
                        'route\defaults'     => array('id' => 123),
                        'route\requirements' => array('id' => '\d+'),
                        'route\options'      => array('a', 'b'),
                        'route\host'         => 'localhost',
                        'route\schemes'      => array('http', 'https'),
                        'route\methods'      => array('POST', 'GET'),
                    ),
                )
            ),
        );

        $source = new AnnotationsRoutesConfigSource('controllers', $allAnnotations);

        $this->assertEquals(array(), $source->getConfig());
    }

    public function testGetConfigIfIncorrectTag()
    {
        $allAnnotations = array(
            'ProductController' => array(
                'class'   => array(
                    'service' => 'controller.product',
                    'tags'    => 'foo'
                ),
                'methods' => array(
                    'indexAction' => array(
                        'route\url'          => '/products/index',
                        'route\defaults'     => array('id' => 123),
                        'route\requirements' => array('id' => '\d+'),
                        'route\options'      => array('a', 'b'),
                        'route\host'         => 'localhost',
                        'route\schemes'      => array('http', 'https'),
                        'route\methods'      => array('POST', 'GET'),
                    ),
                )
            ),
        );

        $source = new AnnotationsRoutesConfigSource('controllers', $allAnnotations);

        $this->assertEquals(array(), $source->getConfig());
    }

    public function testGetConfigIfMoreTags()
    {
        $allAnnotations = array(
            'ProductController' => array(
                'class'   => array(
                    'service' => 'controller.product',
                    'tags'    => array('controllers', 'foo'),
                ),
                'methods' => array(
                    'indexAction' => array(
                        'route\url'          => '/products/index',
                        'route\defaults'     => array('id' => 123),
                        'route\requirements' => array('id' => '\d+'),
                        'route\options'      => array('a', 'b'),
                        'route\host'         => 'localhost',
                        'route\schemes'      => array('http', 'https'),
                        'route\methods'      => array('POST', 'GET'),
                    ),
                )
            ),
        );

        $source = new AnnotationsRoutesConfigSource('controllers', $allAnnotations);

        $expectedConfig = array(
            'controller.product:index' => array(
                'pattern'      => '/products/index',
                'defaults'     => array(
                    'id'          => 123,
                    '_controller' => 'controller.product:index',
                ),
                'requirements' => array('id' => '\d+'),
                'options'      => array('a', 'b'),
                'host'         => 'localhost',
                'schemes'      => array('http', 'https'),
                'methods'      => array('POST', 'GET'),
            )
        );

        $this->assertEquals($expectedConfig, $source->getConfig());
    }

    public function testGetConfigIfNoMethods()
    {
        $allAnnotations = array(
            'ProductController' => array(
                'class'   => array(
                    'service' => 'controller.product',
                    'tags'    => 'controllers'
                ),
                'methods' => array()
            ),
        );

        $source = new AnnotationsRoutesConfigSource('controllers', $allAnnotations);

        $this->assertEquals(array(), $source->getConfig());
    }

    public function testGetConfigIfNoUrlAnnotation()
    {
        $allAnnotations = array(
            'ProductController' => array(
                'class'   => array(
                    'service' => 'controller.product',
                    'tags'    => 'controllers'
                ),
                'methods' => array(
                    'indexAction' => array(
                        'route\defaults'     => array('id' => 123),
                        'route\requirements' => array('id' => '\d+'),
                        'route\options'      => array('a', 'b'),
                        'route\host'         => 'localhost',
                        'route\schemes'      => array('http', 'https'),
                        'route\methods'      => array('POST', 'GET'),
                    ),
                )
            ),
        );

        $source = new AnnotationsRoutesConfigSource('controllers', $allAnnotations);

        $this->assertEquals(array(), $source->getConfig());
    }

    public function testGetConfigIfNoControllerServiceAnnotation()
    {
        $allAnnotations = array(
            'ProductController' => array(
                'class'   => array(
                    'service' => '',
                    'tags'    => 'controllers'
                ),
                'methods' => array(
                    'indexAction' => array(
                        'route\url'          => '/products/index',
                        'route\defaults'     => array('id' => 123),
                        'route\requirements' => array('id' => '\d+'),
                        'route\options'      => array('a', 'b'),
                        'route\host'         => 'localhost',
                        'route\schemes'      => array('http', 'https'),
                        'route\methods'      => array('POST', 'GET'),
                    ),
                )
            ),
        );

        $source = new AnnotationsRoutesConfigSource('controllers', $allAnnotations);

        $expectedConfig = array(
            'productcontroller:index' => array(
                'pattern'      => '/products/index',
                'defaults'     => array(
                    'id'          => 123,
                    '_controller' => 'productcontroller:index',
                ),
                'requirements' => array('id' => '\d+'),
                'options'      => array('a', 'b'),
                'host'         => 'localhost',
                'schemes'      => array('http', 'https'),
                'methods'      => array('POST', 'GET'),
            )
        );

        $this->assertEquals($expectedConfig, $source->getConfig());
    }
}
