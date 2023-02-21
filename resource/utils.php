<?php

    require('constants.php');

    function loginAlreadyExists($dbconn, $Username)
    {
        $stmt = $dbconn->prepare("SELECT username FROM Users WHERE username=?");
        $stmt->bind_param("s", $Username);
        $stmt->execute();
        $potentialUser = $stmt->fetch();
        $stmt->close();

        return $potentialUser != null;
    }

    function getUserId($dbconn, $Username)
    {
        $stmt = $dbconn->prepare("SELECT userID FROM Users WHERE username=?");
        $stmt->bind_param("s", $Username);
        $stmt->execute();
        $currentUserId = $stmt->fetch();

        return $currentUserId;
    }

    function provideResponseViaJSON($response)
    {
        header(DEFAULT_JSON_HEADER);
        echo $response;
    }
?>