<?php
    // Searches for a specified contact from the database
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
        $searchQuery = (!is_null($data->searchQuery)) ? mysqli_real_escape_string($dbconn, stripslashes($data->searchQuery)) : "";
        $searchQuery = "%$searchQuery%";

        // may want to union with a 'partialLastName' as well (selecting from same table)
        $stmt = $dbconn->prepare("SELECT firstName, lastName, phone, email, ContactID FROM Contacts WHERE (userID=?) AND ((firstName LIKE ?) OR (lastName LIKE ?))");
        $stmt->bind_param("sss", $currentUserID, $searchQuery, $searchQuery);
        $stmt->execute();

        $potentialContacts = $stmt->get_result()->fetch_all();
        $response = $potentialContacts;

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