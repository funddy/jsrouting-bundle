<?php

namespace Funddy\Bundle\JsRoutingBundle\ExposedRoutesExtractor;

use Funddy\Bundle\JsRoutingBundle\RoutesExporter\JsRoutesExporter;
use Mockery as m;

/**
 * @copyright (C) Funddy (2012)
 * @author Keyvan Akbary <keyvan@funddy.com>
 * @version 1.0
 */
class JsRoutesExporterTest extends \PHPUnit_Framework_TestCase
{
    const IRRELEVANT_ROUTES = 'XXX';
    const IRRELEVANT_ROUTES_SERIALIZATION = 'XXXX';
    const IRRELEVANT_JS_EXPORT = 'XXXXX';

    private $configuredExposedRoutesExtractorMock;
    private $engineMock;
    private $serializerMock;
    private $jsRoutesExporter;

    public function setUp()
    {
        $this->configuredExposedRoutesExtractorMock = m::mock('Funddy\Bundle\JsRoutingBundle\ExposedRoutesExtractor\ExposedRoutesExtractor');
        $this->serializerMock = m::mock('Symfony\Component\Serializer\SerializerInterface');
        $this->engineMock = m::mock('Symfony\Bundle\FrameworkBundle\Templating\EngineInterface');

        $this->jsRoutesExporter =
            new JsRoutesExporter($this->configuredExposedRoutesExtractorMock, $this->serializerMock, $this->engineMock);
    }

    /**
     * @test
     */
    public function exportShouldBeValid()
    {
        $this->configuredExposedRoutesExtractorExtractRoutesShouldReturnIrrelevantRoutes();
        $this->serializerSerializeWithIrrelevantRoutesShouldReturnIrrelevantRoutesSerialization();
        $this->engineRenderWithIrrelevantRoutesSerializationShouldReturnIrrelevantJsExport();

        $this->assertEquals(self::IRRELEVANT_JS_EXPORT, $this->jsRoutesExporter->export());
    }

    private function configuredExposedRoutesExtractorExtractRoutesShouldReturnIrrelevantRoutes()
    {
        $this->configuredExposedRoutesExtractorMock
            ->shouldReceive('extractRoutes')
            ->andReturn(self::IRRELEVANT_ROUTES);
    }

    private function serializerSerializeWithIrrelevantRoutesShouldReturnIrrelevantRoutesSerialization()
    {
        $this->serializerMock
            ->shouldReceive('serialize')
            ->with(self::IRRELEVANT_ROUTES, 'json')
            ->andReturn(self::IRRELEVANT_ROUTES_SERIALIZATION);
    }

    private function engineRenderWithIrrelevantRoutesSerializationShouldReturnIrrelevantJsExport()
    {
        $this->engineMock
            ->shouldReceive('render')
            ->with('FunddyJsRoutingBundle:JsRouting:routes.js.twig', array('routing' => self::IRRELEVANT_ROUTES_SERIALIZATION))
            ->andReturn(self::IRRELEVANT_JS_EXPORT);
    }
}
