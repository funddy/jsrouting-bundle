<?php

namespace Funddy\Bundle\JsRoutingBundle\Controller;

use Funddy\Bundle\JsRoutingBundle\RoutesExporter\JsRoutesExporter;
use Symfony\Component\HttpFoundation\Response;

class JsRoutingController
{
    private $jsRouterExporter;

    public function __construct(JsRoutesExporter $jsRouterExporter)
    {
        $this->jsRouterExporter = $jsRouterExporter;
    }

    public function exportAction()
    {
        $response = new Response($this->jsRouterExporter->export());
        $response->headers->set('Content-Type', 'text/javascript');
        return $response;
    }
}