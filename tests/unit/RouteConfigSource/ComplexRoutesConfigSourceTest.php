<?php

namespace Butterfly\Component\Sf2Routing\Tests\RouteConfigSource;
use Butterfly\Adapter\Sf2Routing\RouteConfigSource\ComplexRoutesConfigSource;
use Butterfly\Adapter\Sf2Routing\RouteConfigSource\IRoutesConfigSource;

/**
 * @author Marat Fakhertdinov <marat.fakhertdinov@gmail.com>
 */
class ComplexRoutesConfigSourceTest extends \PHPUnit_Framework_TestCase
{
    public function testGetConfig()
    {
        $source1 = $this->getRouteConfigSource();
        $source1
            ->expects($this->once())
            ->method('getConfig')
            ->willReturn(array('source1' => 'value'));
        $source2 = $this->getRouteConfigSource();
        $source2
            ->expects($this->once())
            ->method('getConfig')
            ->willReturn(array('source2' => 'value'));
        $source3 = $this->getRouteConfigSource();
        $source3
            ->expects($this->once())
            ->method('getConfig')
            ->willReturn(array('source3' => 'value'));



        $complexSource = new ComplexRoutesConfigSource(array($source1, $source2));
        $complexSource->addRoutesConfigSource($source3);


        $expectedConfig = array(
            'source1' => 'value',
            'source2' => 'value',
            'source3' => 'value',
        );

        $this->assertEquals($expectedConfig, $complexSource->getConfig());
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|IRoutesConfigSource
     */
    protected function getRouteConfigSource()
    {
        return $this->getMock('Butterfly\Adapter\Sf2Routing\RouteConfigSource\IRoutesConfigSource');
    }
}
