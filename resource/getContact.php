<?php
    // Retrieves the specified contact from the database if it matches the ID of the logged in user
    // Small Group Project 9 - Contact Manager

    require('database.php');
    require('utils.php');
    require('constants.php');

    if($_SERVER['REQUEST_METHOD'] === 'POST')
    {
        $json = file_get_contents(INPUT_PHP);
        $data = json_decode($json);

        $currentUserID = getUserID();

        // Sanitize inputs
        $contactID = (!is_null($data->contactID)) ? mysqli_real_escape_string($dbconn, stripslashes($data->contactID)) : "";

        $stmt = $dbconn->prepare("SELECT firstName, lastName, phone, email, dateCreated FROM Contacts WHERE ContactID=? AND userID=?");
        $stmt->bind_param("ss", $contactID, $currentUserID);
        $stmt->execute();

        $response = $stmt->get_result()->fetch_all();

        $stmt->close();
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