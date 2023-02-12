<?php
    // Registers a new user into contact manager app
    // Small Group Project 9 - Contact Manager

    require('database.php');

    //$DateCreated = date("Y-m-d H:i:s"); (may be completed implicity on db side)
    $Username = stripslashes($_REQUEST['username']);
    $Username = mysqli_real_escape_string($dbconn, $Username);
    $Password = stripslashes($_REQUEST['Password']);
    $Password = mysqli_real_escape_string($dbconn, $Password);

    $Password = password_hash($Password, PASSWORD_BCRYPT);

    $response = "Username is already taken.";
    if (!loginAlreadyExists($dbconn, $Username)) {
        // Add to DB
        $stmt = $dbconn->prepare("INSERT into Users (username, Password)
                                VALUES (?,?)");
        $stmt->bind_param("ss", $Username, $Password);
        $stmt->execute();
        //$respone = $stmt->store_result();
        $response = "Successful account creation.";
        $stmt->close();
    }

    // $response could include auth too ($response = $stmt->get_results())
    provideResponseViaJSON($response);
    $dbconn->close();

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