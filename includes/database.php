<?php
include 'config.php';

// Function to execute SQL queries
function executeQuery($sql) {
    global $mysqli;
    return $mysqli->query($sql);
}

// Function to fetch data from the database
function fetchData($sql) {
    global $mysqli;
    $result = $mysqli->query($sql);
    $data = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }
    return $data;
}

// Function to establish a database connection
function db_connect() {
    global $mysqli;
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    // Check connection
    if ($mysqli->connect_errno) {
        die("Failed to connect to MySQL: " . $mysqli->connect_error);
    }
}

// Function to close the database connection
function db_close() {
    global $mysqli;
    if ($mysqli) {
        $mysqli->close();
    }
}
?>
