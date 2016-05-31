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
use Jose\Factory\JWSFactory;
use Jose\Object\JWE;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class SpomkyAdapter extends JWTProvider implements JWTInterface
{


    /**
     * Create a JSON Web Token.
     *
     * @return string
     * @throws \Tymon\JWTAuth\Exceptions\JWTException
     */
    public function encode(array $payload)
    {
        try {



        } catch (Exception $e) {
            throw new JWTException('Could not create token: '.$e->getMessage());
        }
    }

    /**
     * Decode a JSON Web Token.
     *
     * @param  string  $token
     * @return array
     * @throws \Tymon\JWTAuth\Exceptions\JWTException
     */
    public function decode($token)
    {
        try {


        } catch (Exception $e) {
            throw new TokenInvalidException('Could not decode token: '.$e->getMessage());
        }


        return []; //return payload

    }
}