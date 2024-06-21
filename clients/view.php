<?php
include '../includes/header.php';
include '../includes/database.php';

// Initialize variables
$id = $name = $client_code = '';
$contacts = [];
$errors = [];

// Get the client ID from the URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the client details
    $client = fetchOne("SELECT * FROM clients WHERE id = $id");
    if ($client) {
        $name = $client['name'];
        $client_code = $client['client_code'];
    } else {
        $errors[] = 'Client not found';
    }

    // Fetch the linked contacts
    $contacts = fetchAll("SELECT c.id, c.name, c.surname, c.email
                          FROM contacts c
                          JOIN client_contacts cc ON c.id = cc.contact_id
                          WHERE cc.client_id = $id
                          ORDER BY c.surname, c.name ASC");
} else {
    $errors[] = 'Invalid client ID';
}
?>

<h2>Client Details</h2>

<?php if (!empty($errors)): ?>
    <ul>
        <?php foreach ($errors as $error): ?>
            <li><?php echo htmlspecialchars($error); ?></li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <div>
        <p><strong>Name:</strong> <?php echo htmlspecialchars($name); ?></p>
        <p><strong>Client Code:</strong> <?php echo htmlspecialchars($client_code); ?></p>
    </div>

    <h3>Linked Contacts</h3>

    <?php if (count($contacts) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Surname</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($contacts as $contact): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($contact['name']); ?></td>
                        <td><?php echo htmlspecialchars($contact['surname']); ?></td>
                        <td><?php echo htmlspecialchars($contact['email']); ?></td>
                        <td><a href="unlink.php?client_id=<?php echo htmlspecialchars($id); ?>&contact_id=<?php echo htmlspecialchars($contact['id']); ?>">Unlink</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No contacts found.</p>
    <?php endif; ?>
<?php endif; ?>

<?php include '../includes/footer.php'; ?>
