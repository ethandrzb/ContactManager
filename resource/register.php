<?php
    // Registers a new user into contact manager app
    // Small Group Project 9 - Contact Manager

    require('database.php');
    require('utils.php');
    require('constants.php');

    if($_SERVER['REQUEST_METHOD'] === 'POST')
    {
        $json = file_get_contents(INPUT_PHP);
        $data = json_decode($json);

        $Username = mysqli_real_escape_string($dbconn, stripslashes($data->username));
        $Password = mysqli_real_escape_string($dbconn, stripslashes($data->password));
        $Password = password_hash($Password, PASSWORD_BCRYPT);

        $response = USER_CREATION_200;
        if (!loginAlreadyExists($dbconn, $Username))
        {
            // Add to DB
            $stmt = $dbconn->prepare("INSERT into Users (username, Password)
                                    VALUES (?,?)");
            $stmt->bind_param("ss", $Username, $Password);
            $stmt->execute();
            $stmt->close();

            $response = USER_CREATION_200;
            http_response_code(200);
        }
        else
        {
            $response = USER_CREATION_409;
            http_response_code(409);
        }
        $dbconn->close();
    }
    else
    {
        $response = DEFAULT_RESPONSE_400;
        http_response_code(400);
    }

    provideResponseViaJSON($response);
    exit;
?>