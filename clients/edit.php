<?php
include '../includes/header.php';
include '../includes/database.php';

// Initialize variables
$id = $name = $client_code = '';
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
} else {
    $errors[] = 'Invalid client ID';
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate name
    if (empty($_POST['name'])) {
        $errors[] = 'Name is required';
    } else {
        $name = escapeInput($_POST['name']);
    }

    // If no errors, update the client in the database
    if (empty($errors)) {
        $query = "UPDATE clients SET name = '$name' WHERE id = $id";
        if (executeQuery($query)) {
            header('Location: index.php');
            exit;
        } else {
            $errors[] = 'Failed to update client';
        }
    }
}
?>

<h2>Edit Client</h2>

<?php if (!empty($errors)): ?>
    <ul>
        <?php foreach ($errors as $error): ?>
            <li><?php echo htmlspecialchars($error); ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<form action="edit.php?id=<?php echo htmlspecialchars($id); ?>" method="post">
    <div>
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
    </div>
    <div>
        <label for="client_code">Client Code:</label>
        <input type="text" id="client_code" name="client_code" value="<?php echo htmlspecialchars($client_code); ?>" readonly>
    </div>
    <div>
        <button type="submit">Update Client</button>
    </div>
</form>

<?php include '../includes/footer.php'; ?>
