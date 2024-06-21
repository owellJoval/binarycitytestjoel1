<?php
include '../includes/header.php';
include '../includes/database.php';
include '../includes/functions.php';

// Fetch all contacts
$contacts = fetchAllContacts();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacts</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <div class="container6">
        <h2>Contacts</h2>
        <a href="add.php" class="btn">Add New Contact</a>

        <?php if (count($contacts) > 0): ?>
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
                    <?php foreach ($contacts as $contact): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($contact['name']); ?></td>
                            <td><?php echo htmlspecialchars($contact['surname']); ?></td>
                            <td><?php echo htmlspecialchars($contact['email']); ?></td>
                            <td style="text-align: center;"><?php echo htmlspecialchars($contact['linked_clients']); ?></td>
                            <td><a href="edit.php?id=<?php echo htmlspecialchars($contact['id']); ?>" class="edit-btn">Edit</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No contact(s) found.</p>
        <?php endif; ?>
    </div>

    <?php include '../includes/footer.php'; ?>
</body>

</html>
