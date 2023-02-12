<?php
declare(strict_types=1);

namespace MyApp;

require 'vendor/autoload.php';

use DateTimeImmutable;
use Lcobucci\Clock\FrozenClock;
use Lcobucci\JWT\JwtFacade;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Validation\Constraint;

use function var_dump;

$jwt = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE2NTg2OTYwNTIsIm5iZiI6MT'
    . 'Y1ODY5NjA1MiwiZXhwIjoxNjU4Njk2NjUyLCJpc3MiOiJodHRwczovL2FwaS5teS1hd2Vzb'
    . '21lLWFwcC5pbyIsImF1ZCI6Imh0dHBzOi8vY2xpZW50LWFwcC5pbyJ9.yzxpjyq8lXqMgaN'
    . 'rMEOLUr7R0brvhwXx0gp56uWEIfc';

$key = InMemory::base64Encoded(
    'hiG8DlOKvtih6AxlZn5XKImZ06yu8I3mkOzaJrEuW8yAv8Jnkw330uMt8AEqQ5LB'
);

$token = (new JwtFacade())->parse(
    $jwt,
    new Constraint\SignedWith(new Sha256(), $key),
    new Constraint\StrictValidAt(
        new FrozenClock(new DateTimeImmutable('2022-07-24 20:55:10+00:00'))
    )
);

var_dump($token->claims()->all());