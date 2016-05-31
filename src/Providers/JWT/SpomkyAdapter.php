<?php
/**
 * Created by IntelliJ IDEA.
 * User: isda
 * Date: 31/05/2016
 * Time: 1:17 PM
 */

namespace Tymon\JWTAuth\Providers\JWT;

use Exception;
use Jose\Factory\JWEFactory;
use Jose\Object\JWE;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class SpomkyAdapter extends JWTProvider implements JWTInterface
{

    protected $jwe;

    /**
     * SpomkyAdapter constructor.
     * @param string $secret
     * @param string $algo
     * @param null $driver
     */
    function __construct($secret, $algo, $driver = null)
    {
        parent::__construct($secret, $algo);

        $this->jwe = $driver ?: new JWE(['typ' => 'JWT', 'alg' => $algo]);
    }

    /**
     * @param  array $payload
     * @return string
     */
    public function encode(array $payload)
    {
        // TODO: Implement encode() method.
    }

    /**
     * @param  string $token
     * @return array
     */
    public function decode($token)
    {
        // TODO: Implement decode() method.
    }
}