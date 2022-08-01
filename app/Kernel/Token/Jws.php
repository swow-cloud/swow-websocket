<?php

declare(strict_types=1);
/**
 * This file is part of Swow-Chat.
 *
 * @link     https://xxx.com
 * @document https://xxx.wiki
 * @license  https://github.com/swow-cloud/swow-websocket/master/LICENSE
 */
namespace App\Kernel\Token;

use Hyperf\Utils\Codec\Json;
use Jose\Component\Core\AlgorithmManager;
use Jose\Component\Core\JWK;
use Jose\Component\Signature\JWS as JoseJWS;
use Jose\Component\Signature\JWSBuilder;
use Jose\Component\Signature\JWSVerifier;
use Jose\Component\Signature\Serializer\JWSSerializer;

/**
 * 验证签名.
 */
class Jws
{
    protected AlgorithmManager $algorithmManager;

    protected JWK $jwk;

    protected JWSBuilder $jwsBuilder;

    protected JWSSerializer $serializer;

    protected JWSVerifier $verifier;

    public function __construct()
    {
        $this->algorithmManager = make(AlgorithmManager::class, [
            'algorithms' => [make(config('jws.signature_algorithms'))],
        ]);
        $this->jwk = make(JWK::class, [
            'values' => [
                'kty' => config('jws.kty'),
                'k' => config('jws.key'),
            ],
        ]);
        $this->jwsBuilder = make(JWSBuilder::class, [
            'signatureAlgorithmManager' => $this->algorithmManager,
        ]);
        $this->serializer = make(config('jws.serializer'));
        $this->verifier = make(JWSVerifier::class, [
            'signatureAlgorithmManager' => $this->algorithmManager,
        ]);
    }

    public function create(array $payload): JoseJWS
    {
        /*
         * ['iat' => time(),
         * 'nbf' => time(),
         * 'exp' => time() + 3600,
         * 'iss' => 'My service',
         * 'aud' => 'Your application'],
         */
        return $this->jwsBuilder->create()->withPayload(Json::encode($payload))->addSignature($this->jwk, [
            'alg' => 'HS256',
        ])->build();
    }

    public function serialize(JoseJWS $JWS): string
    {
        return $this->serializer->serialize($JWS);
    }

    public function unserialize(string $token): JoseJWS
    {
        return $this->serializer->unserialize($token);
    }

    public function verify(string $token): bool
    {
        $jws = $this->unserialize($token);

        return $this->verifier->verifyWithKey($jws, $this->jwk, 0);
    }
}
