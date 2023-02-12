<?php
declare(strict_types=1);

// namespace MyApp;

require 'vendor/autoload.php';

use Lcobucci\JWT\Builder;
use Lcobucci\JWT\JwtFacade;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;

// use function var_dump;

$key = InMemory::base64Encoded(
    'U29tZXJzZXQtUHJvcG9zZS1FbXBsb3llZS1UcmFuc2Zvcm1hdGlvbi1BcHBlYWxzLUhlc2l0YXRlZC1FYXN0ZXItVmlydHVlLTE='
);

$token = (new JwtFacade())->issue(
    new Sha256(),
    $key,
    static fn (
        Builder $builder,
        DateTimeImmutable $issuedAt
    ): Builder => $builder
        ->issuedBy('http://localhost/ContactManager/resource/login.php')
        ->permittedFor('http://localhost/ContactManager/resource')
        ->expiresAt($issuedAt->modify('+12 hours'))
        ->withClaim('userID', 12)
);

// var_dump($token->claims()->all());
echo $token->toString();