<?php
include '../includes/header.php';
include '../includes/database.php';
include '../includes/functions.php';

// Initialize variables
$name = $surname = $email = '';
$errors = [];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate name
    if (empty($_POST['name'])) {
        $errors[] = 'Name is required';
    } else {
        $name = escapeInput($_POST['name']);
    }

    // Validate surname
    if (empty($_POST['surname'])) {
        $errors[] = 'Surname is required';
    } else {
        $surname = escapeInput($_POST['surname']);
    }

    // Validate email
    if (empty($_POST['email'])) {
        $errors[] = 'Email is required';
    } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Invalid email format';
    } else {
        $email = escapeInput($_POST['email']);
        // Check for unique email
        $existingEmail = fetchOne("SELECT COUNT(*) AS count FROM contacts WHERE email = '$email'");
        if ($existingEmail['count'] > 0) {
            $errors[] = 'Email already exists';
        }
    }

    // If no errors, insert the new contact into the database
    if (empty($errors)) {
        db_connect();
        global $mysqli;
        
        $name = $mysqli->real_escape_string($name);
        $surname = $mysqli->real_escape_string($surname);
        $email = $mysqli->real_escape_string($email);

        $query = "INSERT INTO contacts (name, surname, email) VALUES ('$name', '$surname', '$email')";
        if ($mysqli->query($query)) {
            // Get the ID of the newly inserted contact
            $contact_id = $mysqli->insert_id;

            // Link clients to the contact
            if (!empty($_POST['clients'])) {
                foreach ($_POST['clients'] as $client_id) {
                    $client_id = intval($client_id); // Sanitize input as integer
                    $mysqli->query("INSERT INTO client_contact (client_id, contact_id) VALUES ($client_id, $contact_id)");
                }
            }

            header('Location: index.php');
            exit;
        } else {
            $errors[] = 'Failed to add contact';
        }
        db_close();
    }
}

// Fetch all clients for display
$clients = fetchAll('clients');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Contact</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <div class="container">
        <h2>Add New Contact</h2>

        <?php if (!empty($errors)): ?>
            <div class="error-messages">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="add.php" method="post">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
            </div>
            <div class="form-group">
                <label for="surname">Surname:</label>
                <input type="text" id="surname" name="surname" value="<?php echo htmlspecialchars($surname); ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
            </div>
            <div class="form-group">
                <label for="clients">Select Clients:</label>
                <select id="clients" name="clients[]" multiple>
                    <?php foreach ($clients as $client): ?>
                        <option value="<?php echo $client['id']; ?>"><?php echo htmlspecialchars($client['name']) . ' (' . htmlspecialchars($client['client_code']) . ')'; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <button type="submit">Add Contact</button>
            </div>
        </form>

        <?php
        // Display the list of clients linked to the respective contact
        $linked_clients = fetchLinkedClients();
        ?>

        <h2>Linked Clients</h2>
        <?php if (empty($linked_clients)): ?>
            <p>No contact(s) found</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Client Name</th>
                        <th>Client Code</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($linked_clients as $client): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($client['name']); ?></td>
                            <td><?php echo htmlspecialchars($client['client_code']); ?></td>
                            <td>
                                <a href="unlink_client.php?client_id=<?php echo $client['id']; ?>" class="unlink-btn">Unlink</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

    <?php include '../includes/footer.php'; ?>
</body>

</html>
