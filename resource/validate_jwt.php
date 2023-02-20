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

function validateJWT($tokenString)
{
    require('secret.php');
    $parser = new Parser(new JoseEncoder());

    try
    {
        $token = $parser->parse($tokenString);
    
        $validator = new Validator();
        $validator->assert($token, new StrictValidAt(new SystemClock(new DateTimeZone('UTC'))));
        $validator->assert($token, new SignedWith(new Sha256(), $key));
    
        return True;
    } catch(CannotDecodeContent $e)
    {
        echo "Invalid token";
    } catch (RequiredConstraintsViolated $e) {
        // list of constraints violation exceptions:
        var_dump($e->violations());
    }

    return False;
}

// var_dump(validateJWT("eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE2NzYzNDAxMTAsIm5iZiI6MTY3NjM0MDExMCwiZXhwIjoxNjc2MzgzMzEwLCJpc3MiOiJodHRwOi8vbG9jYWxob3N0L0NvbnRhY3RNYW5hZ2VyL3Jlc291cmNlL2xvZ2luLnBocCIsImF1ZCI6Imh0dHA6Ly9sb2NhbGhvc3QvQ29udGFjdE1hbmFnZXIvcmVzb3VyY2UiLCJ1c2VySUQiOjEwfQ.Wp-AUEJU8fKnWo4s6O23ei1dqSv7fWo92ar4Zp_22yY"));
?>