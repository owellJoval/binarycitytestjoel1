<?php
include '../includes/database.php';

// Get contact_id from the URL
$contact_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($contact_id > 0) {
    // Delete the contact
    $query = "DELETE FROM contacts WHERE id = $contact_id";
    executeQuery($query);

    // Also unlink the contact from all clients
    $unlinkQuery = "DELETE FROM client_contacts WHERE contact_id = $contact_id";
    executeQuery($unlinkQuery);
}

// Redirect back to the contacts list page
header('Location: index.php');
exit;
?>
