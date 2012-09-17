<?php

namespace Funddy\Bundle\JsRoutingBundle\ExtractedRoute;

use Funddy\Bundle\JsRoutingBundle\ExtractedRoute\ExtractedRoute;
use Symfony\Component\Routing\Route;

/**
 * @copyright (C) Funddy (2012)
 * @author Keyvan Akbary <keyvan@funddy.com>
 * @version 1.0
 */
class ExtractedRouteFactory
{
    public function createFromRoute(Route $route)
    {
        $compiledRoute = $route->compile();

        $defaults = array_intersect_key(
            $route->getDefaults(),
            array_fill_keys($compiledRoute->getVariables(), null)
        );

        $tokens = $compiledRoute->getTokens();

        return new ExtractedRoute($tokens, $defaults);
    }
}
