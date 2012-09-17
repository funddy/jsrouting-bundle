<?php

namespace Funddy\Bundle\JsRoutingBundle\ExposedRoutesExtractor;

/**
 * @copyright (C) Funddy (2012)
 * @author Keyvan Akbary <keyvan@funddy.com>
 * @version 1.0
 */
interface ExposedRoutesExtractor
{
    /**
     * @return array
     */
    public function extractRoutes();
}
