<?php
/**
 * Created by PhpStorm.
 * User: rowen
 * Date: 31/05/2016
 * Time: 5:00 PM
 */

namespace Tymon\JWTAuth\Providers\Config;

use Illuminate\Contracts\Config\Repository as ConfigRepository;

/**
 * Class IlluminateConfigAdapter
 * @package Tymon\JWTAuth\Providers\JWT
 */
class IlluminateConfigAdapter implements ConfigBagInterface
{
    /**
     * @var ConfigRepository
     */
    private $configRepository;

    /**
     * IlluminateConfigAdapter constructor.
     * @param ConfigRepository $configRepository
     */
    public function __construct(ConfigRepository $configRepository)
    {
        $this->configRepository = $configRepository;
    }

    /**
     * Retrieve config by name
     *
     * @param $configName
     * @return string
     */
    public function get($configName)
    {
        return $this->configRepository->get("jwt.$configName");
    }

}