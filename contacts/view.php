<?php
include '../includes/header.php';
include '../includes/database.php';

// Initialize variables
$id = $name = $surname = $email = '';
$clients = $allClients = [];
$errors = [];

// Get the contact ID from the URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the contact details
    $contact = fetchOne("SELECT * FROM contacts WHERE id = $id");
    if ($contact) {
        $name = $contact['name'];
        $surname = $contact['surname'];
        $email = $contact['email'];
    } else {
        $errors[] = 'Contact not found';
    }

    // Fetch the linked clients
    $clients = fetchAll("SELECT cl.id, cl.name, cl.client_code
                          FROM clients cl
                          JOIN client_contacts cc ON cl.id = cc.client_id
                          WHERE cc.contact_id = $id
                          ORDER BY cl.name ASC");

    // Fetch all clients for linking
    $allClients = fetchAll("SELECT id, name, client_code FROM clients ORDER BY name ASC");
} else {
    $errors[] = 'Invalid contact ID';
}

// Handle form submission to link client
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['client_id'])) {
    $client_id = (int)$_POST['client_id'];
    if ($client_id > 0) {
        $query = "INSERT INTO client_contacts (client_id, contact_id) VALUES ($client_id, $id)";
        if (executeQuery($query)) {
            header("Location: view.php?id=$id");
            exit;
        } else {
            $errors[] = 'Failed to link client';
        }
    } else {
        $errors[] = 'Invalid client selected';
    }
}
?>

<h2>Contact Details</h2>

<?php if (!empty($errors)): ?>
    <ul>
        <?php foreach ($errors as $error): ?>
            <li><?php echo htmlspecialchars($error); ?></li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <div>
        <p><strong>Name:</strong> <?php echo htmlspecialchars($name); ?></p>
        <p><strong>Surname:</strong> <?php echo htmlspecialchars($surname); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
    </div>

    <h3>Linked Clients</h3>

    <?php if (count($clients) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Client Name</th>
                    <th>Client Code</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($clients as $client): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($client['name']); ?></td>
                        <td><?php echo htmlspecialchars($client['client_code']); ?></td>
                        <td><a href="unlink.php?contact_id=<?php echo htmlspecialchars($id); ?>&client_id=<?php echo htmlspecialchars($client['id']); ?>">Unlink</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No clients found.</p>
    <?php endif; ?>

    <h3>Link Client</h3>

    <form action="view.php?id=<?php echo htmlspecialchars($id); ?>" method="post">
        <div>
            <label for="client_id">Select Client:</label>
            <select id="client_id" name="client_id" required>
                <option value="">--Select Client--</option>
                <?php foreach ($allClients as $client): ?>
                    <option value="<?php echo htmlspecialchars($client['id']); ?>">
                        <?php echo htmlspecialchars($client['name'] . ' (' . $client['client_code'] . ')'); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <button type="submit">Link Client</button>
        </div>
    </form>
<?php endif; ?>

<?php include '../includes/footer.php'; ?>
