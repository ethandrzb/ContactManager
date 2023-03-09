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

        // Get user's ID to assign to this contact
        $currentUserID = getUserID();

        // Sanitize inputs
        $firstName = (!is_null($data->firstName)) ? mysqli_real_escape_string($dbconn, stripslashes($data->firstName)) : "";
        $lastName = (!is_null($data->lastName)) ? mysqli_real_escape_string($dbconn, stripslashes($data->lastName)) : "";
        $emailAddress = (!is_null($data->email)) ? mysqli_real_escape_string($dbconn, stripslashes($data->email)) : "";
        $phoneNumber = (!is_null($data->phone)) ? mysqli_real_escape_string($dbconn, stripslashes($data->phone)) : "";

        $stmt = $dbconn->prepare("INSERT into Contacts (userID, firstName,
                                    lastName, email, phone) VALUES (?,?,?,?,?)");
        $stmt->bind_param("sssss", $currentUserID, $firstName, $lastName,
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