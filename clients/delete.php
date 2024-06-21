<?php
include '../includes/database.php';

// Get client_id from the URL
$client_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($client_id > 0) {
    // Delete the client
    $query = "DELETE FROM clients WHERE id = $client_id";
    executeQuery($query);
}

// Redirect back to the client's list page
header('Location: index.php');
exit;
?>
