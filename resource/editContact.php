<?php
    // Edits the specified contact from the database
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
        $firstName = (!is_null($data->firstName)) ? mysqli_real_escape_string($dbconn, stripslashes($data->firstName)) : "";
        $lastName = (!is_null($data->lastName)) ? mysqli_real_escape_string($dbconn, stripslashes($data->lastName)) : "";
        $email = (!is_null($data->email)) ? mysqli_real_escape_string($dbconn, stripslashes($data->email)) : "";
        $phone = (!is_null($data->phone)) ? mysqli_real_escape_string($dbconn, stripslashes($data->phone)) : "";

        // Get current field values
        $stmt = $dbconn->prepare("SELECT firstName, lastName, phone, email FROM Contacts WHERE ContactID=? AND userID=?");
        $stmt->bind_param("ss", $contactID, $currentUserID);
        $stmt->execute();
        $result = $stmt->get_result();

        $existingContact = $result->fetch_assoc();

        // Use old value if no new value is provided
        $firstName = empty($firstName) ? $existingContact["firstName"] : $firstName;
        $lastName = empty($lastName) ? $existingContact["lastName"] : $lastName;
        $email = empty($email) ? $existingContact["email"] : $email;
        $phone = empty($phone) ? $existingContact["phone"] : $phone;

        // Update contact with new values
        $stmt = $dbconn->prepare("UPDATE Contacts SET firstName=?, lastName=?, email=?, phone=? WHERE ContactID=? AND userID=?");
        $stmt->bind_param("ssssss", $firstName, $lastName, $email, $phone, $contactID, $currentUserID);
        $stmt->execute();
        $stmt->close();

        // TODO: Change response based on whether anything was actually updated
        $response = "Edit successful";
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