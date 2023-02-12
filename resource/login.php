<?php

    // Establish connection with database
    require('database.php');
    require('utils.php');

    // Parse User object
    $json = file_get_contents('php://input');
    $data = json_decode($json);

    echo $data->username;
    echo nl2br("\n");
    echo $data->password;
    echo nl2br("\n");

    $username = mysqli_real_escape_string($dbconn, stripslashes($data->username));
    $password = mysqli_real_escape_string($dbconn, stripslashes($data->password));

    // Attempt to locate User in database
    if(loginAlreadyExists($dbconn, $username))
    {
        // Get password for this user from database
        $stmt = $dbconn->prepare("SELECT Password FROM Users WHERE username=?");
        $stmt->bind_param("s", $username);
        $stmt->bind_result($out_password);
        $stmt->execute();
        $stmt->fetch();     // Get first result from statement's execution
        $stmt->close();

        echo "Stored password for user ".$username.": ".$out_password;
        echo nl2br("\n");

        $hash = password_hash($password, PASSWORD_BCRYPT);
        echo $hash;
        echo nl2br("\n");

        // Compare passwords
        if(password_verify($password, $out_password))
        {
            echo "Passwords match";
        }
        else
        {
            echo "GTFO";
        }
        // If passwords match, create and return a JWT that grants permission to use any API and expires in 24 hours
        
        // If false, return an error message
    }
    else
    {
        echo "Invalid credentials";
    }
?>