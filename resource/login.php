<?php
    require 'vendor/autoload.php';

    use Lcobucci\JWT\Builder;
    use Lcobucci\JWT\JwtFacade;
    use Lcobucci\JWT\Signer\Hmac\Sha256;

    // Establish connection with database
    require('database.php');
    require('utils.php');
    require('secret.php');

    // Parse User object
    $json = file_get_contents('php://input');
    $data = json_decode($json);

    $username = mysqli_real_escape_string($dbconn, stripslashes($data->username));
    $password = mysqli_real_escape_string($dbconn, stripslashes($data->password));

    // Attempt to locate User in database
    if(loginAlreadyExists($dbconn, $username))
    {
        // Get password for this user from database
        $stmt = $dbconn->prepare("SELECT Password, userID FROM Users WHERE username=?");
        $stmt->bind_param("s", $username);
        $stmt->bind_result($out_password, $out_userID);
        $stmt->execute();
        $stmt->fetch();     // Get first result from statement's execution
        $stmt->close();

        // echo nl2br("Stored password for user ".$username." (ID: ".$out_userID."): ".$out_password."\n");

        // Compare passwords
        if(password_verify($password, $out_password))
        {
            // echo nl2br("Passwords match. Generating JWT\n");
            // If passwords match, create and return a JWT that grants permission to use any API and expires in 24 hours
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
                    ->withClaim('userID', $out_userID)
            );

            // echo $token->toString();
            $response = $token->toString();
        }
        else
        {
            $response = "Invalid credentials";
        }
    }
    else
    {
        $response = "Invalid credentials";
    }

    provideResponseViaJSON($response);
?>