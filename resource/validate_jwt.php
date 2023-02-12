<?php
// TODO: Switch to validate() instead of assert() to speed up validation once login process has been tested and verified

declare(strict_types=1);

use Lcobucci\Clock\SystemClock;
use Lcobucci\JWT\Encoding\JoseEncoder;
use Lcobucci\JWT\Token\Parser;
use Lcobucci\JWT\Validation\Constraint\RelatedTo;
use Lcobucci\JWT\Validation\Constraint\SignedWith;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Validation\Constraint\StrictValidAt;
use Lcobucci\JWT\Validation\RequiredConstraintsViolated;
use Lcobucci\JWT\Encoding\CannotDecodeContent;
use Lcobucci\JWT\Validation\Validator;

require 'vendor/autoload.php';
require('secret.php');

$parser = new Parser(new JoseEncoder());

try
{
    $token = $parser->parse(
    // Valid token
    // "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE2NzYyNDA2NDEsIm5iZiI6MTY3NjI0MDY0MSwiZXhwIjoxNjc2MjgzODQxLCJpc3MiOiJodHRwOi8vbG9jYWxob3N0L0NvbnRhY3RNYW5hZ2VyL3Jlc291cmNlL2xvZ2luLnBocCIsImF1ZCI6Imh0dHA6Ly9sb2NhbGhvc3QvQ29udGFjdE1hbmFnZXIvcmVzb3VyY2UiLCJ1c2VySUQiOjl9.LSK8PuOHQUJxDjwt89j0fb6CCNCSxdQzNSqRf6mqGCA"

    // Valid, but expired token
    // "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.esyJpYXQiOjE2NzYyNDA2NDEsIm5iZiI6MTY3NjI0MDY0MSwiZXhwIjoxNjc2MjQwMDQxLCJpc3MiOiJodHRwOi8vbG9jYWxob3N0L0NvbnRhY3RNYW5hZ2VyL3Jlc291cmNlL2xvZ2luLnBocCIsImF1ZCI6Imh0dHA6Ly9sb2NhbGhvc3QvQ29udGFjdE1hbmFnZXIvcmVzb3VyY2UiLCJ1c2VySUQiOjl9.p2V0lcGJ9SRDdw5mJFYZrvuKKl3ocPjv0g9cW8PnZ-s"

    // Bad token
    "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE2NzYyNDA2EsIm5iZiI6MTY3NjI0MDY0MSwiZXhwIjoxNjc2MjgzODQxLCJpc3MiOiJodHRwOi8vbG9jYWxob3N0L0NvbnRhY3RNYW5hZ2VyL3Jlc291cmNlL2xvZ2luLnBocCIsImF1ZCI6Imh0dHA6Ly9sb2NhbGhvc3QvQ29udGFjdE1hbmFnZXIvcmVzb3VyY2UiLCJ1c2VySUQiOjl9.LSK8PuOHQUJxDjwt89j0fb6CCNCSxdQzNSqRf6mqGCA"
    );

    $validator = new Validator();

    $validator->assert($token, new StrictValidAt(new SystemClock(new DateTimeZone('UTC'))));
    $validator->assert($token, new SignedWith(new Sha256(), $key));
} catch(CannotDecodeContent $e)
{
    echo "Invalid token";
} catch (RequiredConstraintsViolated $e) {
    // list of constraints violation exceptions:
    var_dump($e->violations());
}