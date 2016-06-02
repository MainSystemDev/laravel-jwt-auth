<?php
/**
 * Created by PhpStorm.
 * User: rowen
 * Date: 31/05/2016
 * Time: 4:52 PM
 */

namespace Tymon\JWTAuth\Providers\Config;

/**
 * Interface ConfigBagInterface
 * @package Tymon\JWTAuth\Providers\Config
 */
interface ConfigBagInterface
{
    /**
     * @param $configName
     * @return string
     */
    public function get($configName);
}