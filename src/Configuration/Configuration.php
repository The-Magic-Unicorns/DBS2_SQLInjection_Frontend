<?php

namespace DBS2\Configuration;

require_once(__DIR__ . '/../../configuration.php');

class Configuration
{
    /** @var array Copy of the global configuration array */
    private static $globalConfig;

    public function __construct()
    {
        global $CONFIG;
        self::$globalConfig = $CONFIG;
    }

    /**
     * @return array
     */
    public function getGlobalConfig()
    {
        return self::$globalConfig;
    }
}