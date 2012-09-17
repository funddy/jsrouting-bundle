<?php

namespace Funddy\Bundle\JsRoutingBundle\RoutesExporter;

use Funddy\Bundle\JsRoutingBundle\ExposedRoutesExtractor\ExposedRoutesExtractor;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @copyright (C) Funddy (2012)
 * @author Keyvan Akbary <keyvan@funddy.com>
 * @version 1.0
 */
class JsRoutesExporter implements RoutesExporter
{
    private $exposedRoutesExtractor;
    private $jsonSerializer;
    private $templateEngine;

    public function __construct(
        ExposedRoutesExtractor $exposedRoutesExtractor,
        SerializerInterface $jsonSerializer,
        EngineInterface $templateEngine
    )
    {
        $this->exposedRoutesExtractor = $exposedRoutesExtractor;
        $this->jsonSerializer = $jsonSerializer;
        $this->templateEngine = $templateEngine;
    }

    public function export()
    {
        $routes =  $this->exposedRoutesExtractor->extractRoutes();
        $routing = $this->jsonSerializer->serialize($routes, 'json');

        return $this->templateEngine->render('FunddyJsRoutingBundle:JsRouting:routes.js.twig', array('routing' => $routing));
    }
}