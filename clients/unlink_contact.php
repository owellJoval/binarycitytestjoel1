<?php
include '../includes/database.php';
include '../includes/functions.php';

// Check if client_id is provided in the URL
if (isset($_GET['client_id'])) {
    $client_id = intval($_GET['client_id']); // Sanitize input as integer

    // Fetch client details
    $client = getClientById($client_id);

    // Fetch linked contacts for the client
    $linked_contacts = getLinkedContacts($client_id);

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['contact_id'])) {
        $contact_id = intval($_POST['contact_id']); // Sanitize input as integer

        // Perform the unlinking action
        if (unlinkContact($client_id, $contact_id)) {
            header('Location: index.php');
            exit;
        } else {
            $unlink_error = 'Failed to unlink contact';
        }
    }
} else {
    die('Client ID not provided');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unlink Contacts</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <div class="container5">
        <h2>Unlink Contacts for <?php echo htmlspecialchars($client['name']); ?></h2>
        <p>Select the contact you want to unlink:</p>

        <?php if (!empty($linked_contacts)): ?>
            <form method="post">
                <select name="contact_id" required>
                    <option value="" selected disabled>Select Contact</option>
                    <?php foreach ($linked_contacts as $contact): ?>
                        <option value="<?php echo $contact['id']; ?>"><?php echo htmlspecialchars($contact['name']); ?></option>
                    <?php endforeach; ?>
                </select>
                <button type="submit">Unlink</button>
            </form>
        <?php else: ?>
            <p>No linked contacts found for this client.</p>
        <?php endif; ?>

        <?php if (isset($unlink_error)): ?>
            <p class="error"><?php echo $unlink_error; ?></p>
        <?php endif; ?>
    </div>
</body>

</html>
