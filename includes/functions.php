<?php

// Include the database configuration and functions
include_once 'config.php';
include_once 'database.php';

// Function to fetch all rows from a table
function fetchAll($tableName) {
    db_connect();
    global $mysqli;

    $sql = "SELECT * FROM $tableName ORDER BY name ASC"; // Adjust the query as per your table structure and sorting needs
    $result = $mysqli->query($sql);

    if (!$result) {
        die('Query Error: ' . $mysqli->error);
    }

    $rows = array();
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
    }

    db_close();

    return $rows;
}

// Function to generate a unique client code
function generateClientCode($client_name) {
    db_connect();
    global $mysqli;

    $alpha_part = strtoupper(substr($client_name, 0, 3));
    $numeric_part = 1;

    $query = "SELECT client_code FROM clients WHERE client_code LIKE '$alpha_part%' ORDER BY client_code DESC LIMIT 1";
    $result = $mysqli->query($query);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $last_numeric_part = intval(substr($row['client_code'], 3));
        $numeric_part = $last_numeric_part + 1;
    }

    $client_code = $alpha_part . sprintf("%03d", $numeric_part);
    db_close();

    return $client_code;
}

// Function to fetch all clients with their contact count
function fetchAllClients() {
    db_connect();
    global $mysqli;

    $sql = "SELECT clients.id, clients.name, clients.client_code, COUNT(client_contact.id) as num_contacts 
            FROM clients 
            LEFT JOIN client_contact ON clients.id = client_contact.client_id
            GROUP BY clients.id, clients.name, clients.client_code
            ORDER BY clients.name ASC";
    $result = $mysqli->query($sql);

    if (!$result) {
        die('Query Error: ' . $mysqli->error);
    }

    $clients = array();
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $clients[] = $row;
        }
    }

    db_close();

    return $clients;
}

function getClients() {
    return fetchAllClients();
}

// Function to sanitize user input
function escapeInput($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

function fetchOne($query) {
    db_connect();
    global $mysqli;
    $result = $mysqli->query($query);
    if ($result && $result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        return null;
    }
}


//linking and unlinking contacts
// Function to link a contact to a client
function linkContactToClient($client_id, $contact_id) {
    db_connect();
    global $mysqli;

    $client_id = intval($client_id);
    $contact_id = intval($contact_id);

    $query = "INSERT INTO client_contacts (client_id, contact_id) VALUES ('$client_id', '$contact_id')";
    $result = $mysqli->query($query);

    if (!$result) {
        die('Query Error: ' . $mysqli->error);
    }

    db_close();
}

// Function to unlink a contact from a client
function unlinkContactFromClient($client_id, $contact_id) {
    db_connect();
    global $mysqli;

    $client_id = intval($client_id);
    $contact_id = intval($contact_id);

    $query = "DELETE FROM client_contacts WHERE client_id = '$client_id' AND contact_id = '$contact_id'";
    $result = $mysqli->query($query);

    if (!$result) {
        die('Query Error: ' . $mysqli->error);
    }

    db_close();
}

// Fetch client details by ID
function getClientById($client_id) {
    db_connect();
    global $mysqli;

    $sql = "SELECT * FROM clients WHERE id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('i', $client_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $client = $result->fetch_assoc();
    } else {
        $client = null;
    }

    $stmt->close();
    db_close();

    return $client;
}
// Fetch linked contacts for a client
function getLinkedContacts($client_id) {
    db_connect();
    global $mysqli;

    $sql = "SELECT contacts.id, contacts.name 
            FROM contacts 
            INNER JOIN client_contact ON contacts.id = client_contact.contact_id 
            WHERE client_contact.client_id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('i', $client_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $contacts = array();
    while ($row = $result->fetch_assoc()) {
        $contacts[] = $row;
    }

    $stmt->close();
    db_close();

    return $contacts;
}
// Unlink a contact from a client
function unlinkContact($client_id, $contact_id) {
    db_connect();
    global $mysqli;

    $sql = "DELETE FROM client_contact WHERE client_id = ? AND contact_id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('ii', $client_id, $contact_id);
    $success = $stmt->execute();

    $stmt->close();
    db_close();

    return $success;
}

// Function to fetch all contacts with their linked client count
function fetchAllContacts() {
    db_connect();
    global $mysqli;

    $sql = "SELECT c.id, c.name, c.surname, c.email, 
                   (SELECT COUNT(*) FROM client_contact cc WHERE cc.contact_id = c.id) AS linked_clients
            FROM contacts c
            ORDER BY c.surname, c.name ASC";
    $result = $mysqli->query($sql);

    if (!$result) {
        die('Query Error: ' . $mysqli->error);
    }

    $contacts = array();
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $contacts[] = $row;
        }
    }

    db_close();

    return $contacts;
}


//contacts 




function fetchLinkedClients() {
    db_connect();
    global $mysqli;
    $query = "SELECT clients.id, clients.name, clients.client_code 
              FROM clients 
              JOIN client_contact ON clients.id = client_contact.client_id 
              ORDER BY clients.name ASC";
    $result = $mysqli->query($query);
    $rows = [];
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }
    db_close();
    return $rows;
}
function fetchLinkedContacts() {
    db_connect();
    global $mysqli;
    $query = "SELECT contacts.id, contacts.name, contacts.surname, contacts.email
              FROM contacts 
              JOIN client_contact ON contacts.id = client_contact.contact_id 
              ORDER BY contacts.name ASC";
    $result = $mysqli->query($query);
    $rows = [];
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }
    db_close();
    return $rows;
}

?>
