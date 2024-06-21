<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=de, initial-scale=1.0">
    <title>Add New Client</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<?php
include '../includes/header.php';
include '../includes/database.php';
include '../includes/functions.php';

// Initialize variables
$name = $client_code = '';
$errors = [];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate name
    if (empty($_POST['name'])) {
        $errors[] = 'Name is required';
    } else {
        $name = escapeInput($_POST['name']);
    }

    // Generate client code if name is valid
    if (empty($errors)) {
        $client_code = generateClientCode($name);
    }

    // If no errors, insert the new client into the database
    if (empty($errors)) {
        db_connect();
        global $mysqli;

        $name = $mysqli->real_escape_string($name);
        $client_code = $mysqli->real_escape_string($client_code);

        $query = "INSERT INTO clients (name, client_code) VALUES ('$name', '$client_code')";
        if ($mysqli->query($query)) {
            // Get the ID of the newly inserted client
            $client_id = $mysqli->insert_id;

            // Link contacts to the client
            if (!empty($_POST['contacts'])) {
                foreach ($_POST['contacts'] as $contact_id) {
                    $contact_id = intval($contact_id); // Sanitize input as integer
                    $mysqli->query("INSERT INTO client_contact (client_id, contact_id) VALUES ($client_id, $contact_id)");
                }
            }

            header('Location: index.php');
            exit;
        } else {
            $errors[] = 'Failed to add client';
        }
        db_close();
    }
}

// Fetch all contacts for display
$contacts = fetchAll('contacts');
?>

<div class="container4">
    <h2>Add New Client</h2>

    <?php if (!empty($errors)): ?>
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?php echo htmlspecialchars($error); ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form action="add.php" method="post">
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
        </div>
        <div class="form-group">
            <label for="client_code">Client Code:</label>
            <input type="text" id="client_code" name="client_code" value="<?php echo htmlspecialchars($client_code); ?>" readonly>
        </div>
        <div class="form-group">
            <label for="contacts">Select Contacts:</label>
            <select id="contacts" name="contacts[]" multiple>
                <?php foreach ($contacts as $contact): ?>
                    <option value="<?php echo $contact['id']; ?>"><?php echo htmlspecialchars($contact['name'] . ' ' . $contact['surname']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <button type="submit" class="add-button">Add Client</button>
        </div>
    </form>

    <h2>Linked Contacts</h2>
    <?php
    // Display the list of clients linked to the respective contact
    $linked_contact = fetchLinkedContacts();
    ?>
    <?php if (empty($linked_contact)): ?>
        <p>No contact(s) found</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Contact Name</th>
                    <th>Contact Surname</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($linked_contact as $contact): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($contact['name']); ?></td>
                        <td><?php echo htmlspecialchars($contact['surname']); ?></td>
                        <td><a class="action-link" href="unlink.php?contact_id=<?php echo $contact['id']; ?>&client_id=<?php echo $client_id; ?>">Unlink</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>



</body>
</html>
