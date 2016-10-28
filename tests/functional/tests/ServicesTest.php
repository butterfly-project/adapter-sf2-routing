<?php

namespace Butterfly\Tests;

class ServicesTest extends BaseDiTest
{
    protected static function getAdditionalConfigPaths()
    {
        return array(
            self::$baseDir . '/config/test.yml',
        );
    }

    public function getDataForTestParameter()
    {
        return array(
            array('annotations', array()),
            array('bfy_adapter.sf2_routing.routing', array()),
        );
    }

    /**
     * @dataProvider getDataForTestParameter
     * @param string $parameterName
     * @param mixed $expectedValue
     */
    public function testParameter($parameterName, $expectedValue)
    {
        $this->assertEquals($expectedValue, self::$container->getParameter($parameterName));
    }

    public function getDataForTestService()
    {
        return array(
            array('bfy_adapter.sf2_routing.source.simple'),
            array('bfy_adapter.sf2_routing.source.annotation'),
            array('bfy_adapter.sf2_routing.compex_route_source'),
            array('bfy_adapter.sf2_routing.request_context'),
            array('bfy_adapter.sf2_routing.route_factory'),
            array('bfy_adapter.sf2_routing.routes'),
            array('bfy_adapter.sf2_routing.url_generator'),
            array('bfy_adapter.sf2_routing.url_matcher'),
            array('bfy_adapter.sf2_routing.router'),
        );
    }

    /**
     * @dataProvider getDataForTestService
     * @param string $serviceName
     */
    public function testService($serviceName)
    {
        self::$container->get($serviceName);
    }

    public function getDataForTestTag()
    {
        return array(
            array('bfy_app.routing', 1),
        );
    }

    /**
     * @dataProvider getDataForTestTag
     * @param string $name
     * @param int $count
     */
    public function testTag($name, $count)
    {
        $this->assertTrue(self::$container->hasTag($name));
        $this->assertCount($count, self::$container->getServicesByTag($name));
    }
}
