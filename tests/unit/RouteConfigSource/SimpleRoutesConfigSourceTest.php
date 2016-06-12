<?php

namespace Butterfly\Component\Sf2Routing\Tests\RouteConfigSource;

use Butterfly\Adapter\Sf2Routing\RouteConfigSource\SimpleRoutesConfigSource;

/**
 * @author Marat Fakhertdinov <marat.fakhertdinov@gmail.com>
 */
class SimpleRoutesConfigSourceTest extends \PHPUnit_Framework_TestCase
{
    public function testGetConfig()
    {
        $config = array(
            'route1' => 'configuration of route1',
        );

        $source = new SimpleRoutesConfigSource($config);

        $this->assertEquals($config, $source->getConfig());
    }
}
