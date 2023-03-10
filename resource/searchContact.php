<?php
    // Returns all contacts belonging to the logged-in user that are similar to the search string
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
        $page = (!is_null($data->page)) ? mysqli_real_escape_string($dbconn, stripslashes($data->page)) : "1";
        $page = intval($page);
        $resultsPerPage = (!is_null($data->resultsPerPage)) ? mysqli_real_escape_string($dbconn, stripslashes($data->resultsPerPage)) : "25";
        $resultsPerPage = intval($resultsPerPage);

        $offset = $resultsPerPage * ($page - 1);

        // Return all contacts belonging to a user if no search query is given
        if(empty($searchQuery))
        {
            $stmt = $dbconn->prepare("SELECT firstName, lastName, phone, email, ContactID FROM Contacts WHERE userID=? LIMIT ? OFFSET ?");
            $stmt->bind_param("sii", $currentUserID, $resultsPerPage, $offset);
        }
        else
        {
            $stmt = $dbconn->prepare("SELECT firstName, lastName, phone, email, ContactID FROM Contacts WHERE (userID=?) AND ((firstName LIKE ?) OR (lastName LIKE ?)) LIMIT ? OFFSET ?");
            $stmt->bind_param("sssii", $currentUserID, $searchQuery, $searchQuery, $resultsPerPage, $offset);
        }

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