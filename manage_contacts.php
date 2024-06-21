<?php
include '../includes/header.php';
include '../includes/database.php';
include '../includes/functions.php';

// Fetch all contacts linked to clients
$linked_contacts = fetchAllLinkedContacts();

?>

<h2>Manage Linked Contacts</h2>

<?php if (!empty($linked_contacts)): ?>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Surname</th>
                <th>Email</th>
                <th>No. of Linked Clients</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($linked_contacts as $contact): ?>
                <tr>
                    <td><?php echo htmlspecialchars($contact['name']); ?></td>
                    <td><?php echo htmlspecialchars($contact['surname']); ?></td>
                    <td><?php echo htmlspecialchars($contact['email']); ?></td>
                    <td><?php echo $contact['num_clients']; ?></td>
                    <td><a href="unlink_contact.php?contact_id=<?php echo $contact['id']; ?>">Unlink</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No contacts linked to clients.</p>
<?php endif; ?>

<?php include '../includes/footer.php'; ?>
