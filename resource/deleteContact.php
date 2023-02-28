<?php
    // Deletes the specified contact from the database
    // Small Group Project 9 - Contact Manager

    require('database.php');
    require('utils.php');
    require('constants.php');

    if($_SERVER['REQUEST_METHOD'] === 'POST')
    {
        $json = file_get_contents(INPUT_PHP);
        $data = json_decode($json);

        //TODO: Compare logged in user ID with user ID of contact they want to delete
        $currentUserID = getUserID();

        // Sanitize inputs
        $contactID = (!is_null($data->contactID)) ? mysqli_real_escape_string($dbconn, stripslashes($data->contactID)) : "";

        $stmt = $dbconn->prepare("DELETE FROM Contacts WHERE ContactID=(?)");
        $stmt->bind_param("s", $contactID);
        $stmt->execute();
        $stmt->close();

        $response = "Deletion successful";
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