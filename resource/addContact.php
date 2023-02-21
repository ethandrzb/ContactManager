<?php
    // Registers a new contact into contact manager app
    // Small Group Project 9 - Contact Manager

    require('database.php');
    require('utils.php');
    require('constants.php');

    if($_SERVER['REQUEST_METHOD'] === 'POST')
    {
        $json = file_get_contents(INPUT_PHP);
        $data = json_decode($json);

        // need a way to get current user -> then query
        // for userID to add to contact in db
        // to accomplish this, in login.php:
        // - $_SESSION['username'] = $username (before termination)
        // this allows all other endpoints to access username in session variable
        // also JWT can be stored in session variable if need be
        $currentUser = $_SESSION['username'];
        if ($currentUser == null)
        {
            $response = DEFAULT_AUTHENTICATE_401;
            http_response_code(401);
            provideResponseViaJSON($response);
            exit;
        }
        $currentUserId = getUserId($dbconn, $currentUser);
        $firstName = mysqli_real_escape_string($dbconn, stripslashes($data->firstName));
        $lastName = mysqli_real_escape_string($dbconn, stripslashes($data->lastName));
        $emailAddress = mysqli_real_escape_string($dbconn, stripslashes($data->email));
        $phoneNumber = mysqli_real_escape_string($dbconn, stripslashes($data->phone));

        $stmt = $dbconn->prepare("INSERT into Contacts (userID, firstName,
                                    lastName, email, phone) VALUES (?,?,?,?,?)");
        $stmt->bind_param("sssss", $currentUser, $firstName, $lastName,
                            $emailAddress, $phoneNumber);
        $stmt->execute();
        $stmt->close();

        $response = CONTACT_CREATION_200;
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