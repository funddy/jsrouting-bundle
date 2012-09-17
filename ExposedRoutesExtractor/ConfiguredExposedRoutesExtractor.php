<?php

namespace Funddy\Bundle\JsRoutingBundle\ExposedRoutesExtractor;

use Funddy\Bundle\JsRoutingBundle\ExtractedRoute\ExtractedRouteFactory;
use Symfony\Component\Routing\RouterInterface;

/**
 * @copyright (C) Funddy (2012)
 * @author Keyvan Akbary <keyvan@funddy.com>
 * @version 1.0
 */
class ConfiguredExposedRoutesExtractor implements ExposedRoutesExtractor
{
    private $router;
    private $extractedRouteFactory;

    public function __construct(RouterInterface $router, ExtractedRouteFactory $extractedRouteFactory)
    {
        $this->router = $router;
        $this->extractedRouteFactory = $extractedRouteFactory;
    }

    public function extractRoutes()
    {
        $exposedRoutes = array();
        $collection = $this->router->getRouteCollection();
        foreach ($collection->all() as $name => $route) {
            if (!$route->getOption('expose', false)) {
                continue;
            }

            $exposedRoutes[$name] = $this->extractedRouteFactory->createFromRoute($route);
        }

        return $exposedRoutes;
    }
}
