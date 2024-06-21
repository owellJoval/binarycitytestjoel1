<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clients</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    
<?php
include '../includes/header.php';
include '../includes/database.php';
require_once '../includes/functions.php';

$clients = getClients();
?>

<div class="container3">
    <h2>Clients</h2>
    <a class="add-button" href="add.php">Add New Client</a>

    <?php if (count($clients) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Client Code</th>
                    <th>No. of Linked Contacts</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($clients as $client): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($client['name']); ?></td>
                        <td><?php echo htmlspecialchars($client['client_code']); ?></td>
                        <td class="center"><?php echo (int)$client['num_contacts']; ?></td>
                        <td>
                            <a class="action-link" href="unlink_contact.php?client_id=<?php echo $client['id']; ?>">Unlink</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No client(s) found.</p>
    <?php endif; ?>
</div>


</body>
</html>
