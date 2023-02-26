<?php
    require 'vendor/autoload.php';
    require('constants.php');
    require('parse_jwt.php');

    function loginAlreadyExists($dbconn, $Username)
    {
        $stmt = $dbconn->prepare("SELECT username FROM Users WHERE username=?");
        $stmt->bind_param("s", $Username);
        $stmt->execute();
        $potentialUser = $stmt->fetch();
        $stmt->close();

        return $potentialUser != null;
    }

    // function getUserId($dbconn, $Username)
    // {
    //     $stmt = $dbconn->prepare("SELECT userID FROM Users WHERE username=?");
    //     $stmt->bind_param("s", $Username);
    //     $stmt->execute();
    //     $currentUserId = $stmt->fetch();

    //     return $currentUserId;
    // }
    function getUserID()
    {
        $cookie_name = "JWT";

        // Only procede if JWT cookie is present
        if((isset($_COOKIE[$cookie_name])))
        {
            return parseJWT($_COOKIE[$cookie_name], "userID");
        }
        else
        {
            echo "Cookie not found" . PHP_EOL;
            http_response_code(401);
            exit;
        }
    }

    function provideResponseViaJSON($response)
    {
        header(DEFAULT_JSON_HEADER);
        echo $response;
    }
?>