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
use Jose\Factory\JWKFactory;
use Jose\Factory\JWSFactory;
use Jose\Loader;
use Jose\Object\JWKInterface;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Providers\Config\ConfigBagInterface;
use Tymon\JWTAuth\Token;

/**
 * Class SpomkyAdapter
 * @package Tymon\JWTAuth\Providers\JWT
 */
class SpomkyAdapter extends JWTProvider implements JWTInterface
{
    /**
     * @var JWKInterface
     */
    private $signatureKey;

    /**
     * @var JWKInterface
     */
    private $encryptionKey;

    /**
     * SpomkyAdapter constructor.
     * @param ConfigBagInterface $configBag
     */
    public function __construct(ConfigBagInterface $configBag)
    {
        parent::__construct($configBag->get('sign_secret'), $configBag->get('sign_algo'));

        $this->signatureKey = $this->buildSignatureKey(
            $configBag->get('sign_secret'),
            $configBag->get('sign_algo')
        );

        $this->encryptionKey = $this->buildEncryptionKey(
            $configBag->get('encrypt_secret'),
            $configBag->get('encrypt_algo')
        );
    }

    /**
     * Build signature key
     *
     * @param $secret
     * @param $algo
     * @return JWKInterface|\Jose\Object\JWKSetInterface
     */
    private function buildSignatureKey($secret, $algo)
    {
        return JWKFactory::createFromValues([
            'kty' => 'oct',
            'k'   => $secret,
            'alg' => $algo,
        ]);
    }

    /**
     * Build encryption key
     *
     * @param $secret
     * @param $algo
     * @return JWKInterface|\Jose\Object\JWKSetInterface
     */
    private function buildEncryptionKey($secret, $algo)
    {
        return JWKFactory::createFromValues([
            'kty' => 'oct',
            'k'   => $secret,
            'alg' => $algo,
        ]);
    }

    /**
     * Create a JSON Web Token.
     *
     * @param array $payload
     * @return string
     * @throws JWTException
     */
    public function encode(array $payload)
    {
        try {

            $token = JWEFactory::createJWEToCompactJSON(
                $payload,
                $this->encryptionKey,
                [
                    'alg' => 'dir',
                    'enc' => $this->encryptionKey->get('alg'),
                    'zip' => 'DEF'
                ]
            );

            return JWSFactory::createJWSToCompactJSON($token, $this->signatureKey, [
                'alg' => $this->signatureKey->get('alg'),
                'zip' => 'DEF'
            ]);

        } catch (Exception $e) {

            throw new JWTException('Could not create token: '.$e->getMessage());
        }
    }

    /**
     * Decode a JSON Web Token.
     *
     * @param  Token  $token
     * @return array
     * @throws \Tymon\JWTAuth\Exceptions\JWTException
     */
    public function decode($token)
    {
        try {

            $loader = new Loader();

            $verifiedJWS = $loader->loadAndVerifySignatureUsingKey(
                (string) $token,
                $this->signatureKey,
                [
                    $this->signatureKey->get('alg')
                ]
            );

            $jwe = $loader->loadAndDecryptUsingKey(
                $verifiedJWS->getPayload(),
                $this->encryptionKey,
                [
                    'dir'
                ],
                [
                    $this->encryptionKey->get('alg')
                ]
            );

        } catch (Exception $e) {

            throw new TokenInvalidException('Could not decode token: ' . $e->getMessage());
        }

        return $jwe->getPayload();
    }
}