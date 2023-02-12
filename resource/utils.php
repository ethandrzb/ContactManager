<?php
    function loginAlreadyExists($dbconn, $Username)
    {
        $stmt = $dbconn->prepare("SELECT username FROM Users WHERE username=?");
        $stmt->bind_param("s", $Username);
        $stmt->execute();
        $potentialUser = $stmt->fetch();
        $stmt->close();

        $doesExist = false;
        if ($potentialUser != null)
            $doesExist = true;

        return $doesExist;
    }

    function provideResponseViaJSON($response)
    {
        header('Content-type: application/json');
        echo $response;
    }
?>