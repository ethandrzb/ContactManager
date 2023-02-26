<?php
// TODO: Switch to validate() instead of assert() to speed up validation once login process has been tested and verified

declare(strict_types=1);

use Lcobucci\Clock\SystemClock;
use Lcobucci\JWT\JwtFacade;
use Lcobucci\JWT\Encoding\CannotDecodeContent;
use Lcobucci\JWT\Encoding\JoseEncoder;
use Lcobucci\JWT\Token\InvalidTokenStructure;
use Lcobucci\JWT\Validation\RequiredConstraintsViolated;
use Lcobucci\JWT\Token\Parser;
use Lcobucci\JWT\Token\UnsupportedHeaderFound;
use Lcobucci\JWT\UnencryptedToken;
use Lcobucci\JWT\Validation\Constraint\StrictValidAt;
use Lcobucci\JWT\Validation\Constraint\SignedWith;
use Lcobucci\JWT\Signer\Hmac\Sha256;

require 'vendor/autoload.php';

function parseJWT($tokenString, $fieldName)
{
    require('secret.php');
    
    try
    {
        $token = (new JWTFacade())->parse(
            $tokenString,
            new SignedWith(new Sha256(), $key),
            new StrictValidAt(new SystemClock(new DateTimeZone('UTC')))
        );

        if($token instanceof UnencryptedToken)
        {
            return $token->claims()->get($fieldName);
        }
    } catch(CannotDecodeContent | InvalidTokenStructure| UnsupportedHeaderFound | RequiredConstraintsViolated $e) {
        $response = "Error parsing JWT: " . $e->getMessage() . PHP_EOL;
        provideResponseViaJSON($response);
    }
}

// Valid JWT
// echo parseJWT("eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE2Nzc0MzAzMTYsIm5iZiI6MTY3NzQzMDMxNiwiZXhwIjoxNjc3NDczNTE2LCJpc3MiOiJodHRwOi8vbG9jYWxob3N0L0NvbnRhY3RNYW5hZ2VyL3Jlc291cmNlL2xvZ2luLnBocCIsImF1ZCI6Imh0dHA6Ly9sb2NhbGhvc3QvQ29udGFjdE1hbmFnZXIvcmVzb3VyY2UiLCJ1c2VySUQiOjl9.116JOSM-6hq7ymw0bvupVEY1lowxOJJW0-aDhr6MW9s", 'userID'), PHP_EOL;

// Bad signature
// echo parseJWT("eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE2Nzc0MzAzMTYsIm5iZiI6MTY3NzQzMDMxNiwiZXhwIjoxNjc3NDczNTE2LCJpc3MiOiJodHRwOi8vbG9jYWxob3N0L0NvbnRhY3RNYW5hZ2VyL3Jlc291cmNlL2xvZ2luLnBocCIsImF1ZCI6Imh0dHA6Ly9sb2NhbGhvc3QvQ29udGFjdE1hbmFnZXIvcmVzb3VyY2UiLCJ1c2VySUQiOjl9.116JOSM-6hq7ymw0bvupVEY1losdghfwxOJJW0-aDhr6MW9s", 'userID'), PHP_EOL;

// Invalid token header
// echo parseJWT("eyJ0eXAiOiJKV1QiLCJhbGasdgciOiJIUzI1NiJ9.eyJpYXQiOjE2Nzc0MzAzMTYsIm5iZiI6MTY3NzQzMDMxNiwiZXhwIjoxNjc3NDczNTE2LCJpc3MiOiJodHRwOi8vbG9jYWxob3N0L0NvbnRhY3RNYW5hZ2VyL3Jlc291cmNlL2xvZ2luLnBocCIsImF1ZCI6Imh0dHA6Ly9sb2NhbGhvc3QvQ29udGFjdE1hbmFnZXIvcmVzb3VyY2UiLCJ1c2VySUQiOjl9.116JOSM-6hq7ymw0bvupVEY1lowxOJJW0-aDhr6MW9s", 'userID'), PHP_EOL;

// Invalid token
// echo parseJWT("eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE2Nzc0MzAzMTYsIm5iZiI6MTY3NzQzMDMxNiwiZXhwIjoxNjc3NDczNTE2LCJpc3MiOiJodHRwOi8vbG9jYWxob3N0L0NvbnRhY3RNYW5hZ2VyL3Jlc291cmNlL2xvZ2luLnBocCIsImF1ZCI6Imh0dHA6Ly9sb2NhbGhvc3asdgQvQ29udGFjdE1hbmFnZXIvcmVzb3VyY2UiLCJ1c2VySUQiOjl9.116JOSM-6hq7ymw0bvupVEY1lowxOJJW0-aDhr6MW9s", 'userID'), PHP_EOL;
?>