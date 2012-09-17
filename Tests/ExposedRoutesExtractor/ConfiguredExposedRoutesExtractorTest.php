<?php

namespace Funddy\Bundle\JsRoutingBundle\ExposedRoutesExtractor;

use Funddy\Bundle\JsRoutingBundle\ExposedRoutesExtractor\ConfiguredExposedRoutesExtractor;
use Mockery as m;

class ConfiguredExposedRoutesExtractorTest extends \PHPUnit_Framework_TestCase
{
    const IRRELEVANT_EXTRACTED_ROUTE = 'XXX';

    private $routerMock;
    private $extractedRouteFactory;

    public function setUp()
    {
        $this->routerMock = m::mock('Symfony\Component\Routing\Router');
        $this->extractedRouteFactory = m::mock('Funddy\Bundle\JsRoutingBundle\ExtractedRoute\ExtractedRouteFactory');
        $this->configuredExposedRoutesExtractor =
            new ConfiguredExposedRoutesExtractor($this->routerMock, $this->extractedRouteFactory);
    }

    /**
     * @test
     */
    public function onlyExposedRoutesShouldBeExtracted()
    {
        $this->routeFactoryCreateFromRouteShouldReturn(self::IRRELEVANT_EXTRACTED_ROUTE);

        $this->routerShouldHaveOneExposedAndOneNonExposedRoutes();
        $exposedRoutes = $this->configuredExposedRoutesExtractor->extractRoutes();

        $this->assertEquals(1, count($exposedRoutes));
        $this->assertArrayHasKey('exposed_route', $exposedRoutes);
    }

    private function routeFactoryCreateFromRouteShouldReturn($return)
    {
        $this->extractedRouteFactory
            ->shouldReceive('createFromRoute')
            ->andReturn($return);
    }

    private function routerShouldHaveOneExposedAndOneNonExposedRoutes()
    {
        $this->routerMock
            ->shouldReceive('getRouteCollection')
            ->andReturn(m::mock('Symfony\Component\Routing\RouteCollection')
                ->shouldReceive('all')
                ->andReturn(array(
                    'exposed_route' => $this->createExposedRouteMock(),
                    'non_exposed_route' => $this->createNonExposedRouteMock()
                ))
            ->mock());
    }

    private function createExposedRouteMock()
    {
        $exposedRoute = $this->createRouteMock();
        $this->routeExposeOptionShouldReturn($exposedRoute, true);

        return $exposedRoute;
    }

    private function createRouteMock()
    {
        return m::mock('Symfony\Component\Routing\Route');
    }

    private function routeExposeOptionShouldReturn($routeMock, $return)
    {
        $routeMock
            ->shouldReceive('getOption')
            ->with('expose', m::any())
            ->andReturn($return);
    }

    private function createNonExposedRouteMock()
    {
        $nonExposedRoute = $this->createRouteMock();
        $this->routeExposeOptionShouldReturn($nonExposedRoute, false);

        return $nonExposedRoute;
    }
}
