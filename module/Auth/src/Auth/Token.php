<?php

namespace Auth\Auth;

use Namshi\JOSE\SimpleJWS;
use Zend\View\Model\JsonModel;

class Token
{
    const KEY = "62d42607edddd373bbe5acvc37e607edd373bbe5acvca307ed151115ae5a";

    static function validateSignature(string $authorization)
    {
        $jws = SimpleJWS::Load(str_replace('Bearer ', '', $authorization));

        return $jws->isValid(self::KEY);
    }

    static function generateAuthorization(array $payload): JsonModel
    {
        $jws = new SimpleJWS(['alg' => 'HS256']);

        $jws->setPayload($payload);

        $jws->sign(self::KEY);

        return new JsonModel(['token' => $jws->getTokenString()]);
    }

    static function getValidPayload(string $authorization)
    {
        if (self::validateSignature($authorization)) {
            return SimpleJWS::load($authorization)->getPayload();
        }

        return false;
    }
}