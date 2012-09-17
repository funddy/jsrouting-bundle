<?php

namespace Funddy\Bundle\JsRoutingBundle\ExtractedRoute;

/**
 * @copyright (C) Funddy (2012)
 * @author Keyvan Akbary <keyvan@funddy.com>
 * @version 1.0
 */
class ExtractedRoute
{
    private $tokens;
    private $defaults;

    public function __construct($tokens, $defaults)
    {
        $this->tokens = $tokens;
        $this->defaults = $defaults;
    }

    public function getTokens()
    {
        return $this->tokens;
    }

    public function getDefaults()
    {
        return $this->defaults;
    }
}
