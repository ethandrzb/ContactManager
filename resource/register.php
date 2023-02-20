<?php
    // Registers a new user into contact manager app
    // Small Group Project 9 - Contact Manager

    require('database.php');
    require('utils.php');

    //$DateCreated = date("Y-m-d H:i:s"); (may be completed implicity on db side)

    $json = file_get_contents('php://input');
    $data = json_decode($json);

    $Username = stripslashes($data->username);
    $Username = mysqli_real_escape_string($dbconn, $Username);
    $Password = stripslashes($data->password);
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
    else
    {
        http_response_code(409);
    }

    // $response could include auth too ($response = $stmt->get_results())
    provideResponseViaJSON($response);
    $dbconn->close();
?>