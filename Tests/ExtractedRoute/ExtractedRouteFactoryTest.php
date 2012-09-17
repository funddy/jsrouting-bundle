<?php

namespace Funddy\Bundle\JsRoutingBundle\Tests\ExtractedRoute;

use Funddy\Bundle\JsRoutingBundle\ExtractedRoute\ExtractedRouteFactory;
use Mockery as m;

/**
 * @copyright (C) Funddy (2012)
 * @author Keyvan Akbary <keyvan@funddy.com>
 * @version 1.0
 */
class ExtractedRouteFactoryTest extends \PHPUnit_Framework_TestCase
{
    private $routeMock;
    private $compiledRouteMock;
    private $extractedRouteFactory;

    public function setUp()
    {
        $this->routeMock = m::mock('Symfony\Component\Routing\Route');
        $this->compiledRouteMock = m::mock('Symfony\Component\Routing\CompiledRoute');
        $this->extractedRouteFactory = new ExtractedRouteFactory();
    }

    /**
     * @test
     */
    public function createFromRouteShouldReturnTheSameTokens()
    {
        $tokens = array('XX', 'X');
        $defaults = array('XX' => 'XX');
        $variables = array('X' => '', 'XX' => 'XX', 'X' => '');

        $this->compiledRouteGetTokensShouldReturn($tokens);
        $this->compiledRouteGetVariablesShouldReturn($variables);
        $this->routeCompileShouldReturnCompiledRouteMock();
        $this->routeGetDefaultsShouldReturn($defaults);

        $extractedRoute = $this->extractedRouteFactory->createFromRoute($this->routeMock);

        $this->assertEquals($tokens, $extractedRoute->getTokens());
    }

    private function compiledRouteGetTokensShouldReturn($return)
    {
        $this->compiledRouteMock
            ->shouldReceive('getTokens')->once()
            ->andReturn($return);
    }

    private function compiledRouteGetVariablesShouldReturn($return)
    {
        $this->compiledRouteMock
            ->shouldReceive('getVariables')->once()
            ->andReturn($return);
    }

    private function routeCompileShouldReturnCompiledRouteMock()
    {
        $this->routeMock
            ->shouldReceive('compile')->once()
            ->andReturn($this->compiledRouteMock);
    }

    private function routeGetDefaultsShouldReturn($return)
    {
        $this->routeMock
            ->shouldReceive('getDefaults')->once()
            ->andReturn($return);
    }

    /**
     * @test
     */
    public function createFromRouteShouldReturnTheIntersectionBetweenDefaultsAndVariables()
    {
        $tokens = array('XX', 'X');
        $defaults = array('XX' => 'XX');
        $variables = array('X' => '');

        $this->compiledRouteGetTokensShouldReturn($tokens);
        $this->compiledRouteGetVariablesShouldReturn($variables);
        $this->routeCompileShouldReturnCompiledRouteMock();
        $this->routeGetDefaultsShouldReturn($defaults);

        $extractedRoute = $this->extractedRouteFactory->createFromRoute($this->routeMock);

        $this->assertEquals(array(), $extractedRoute->getDefaults());
    }
}
