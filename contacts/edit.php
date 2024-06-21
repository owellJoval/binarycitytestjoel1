
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Contact</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<?php
include '../includes/header.php';
include '../includes/database.php';
include '../includes/functions.php';

// Initialize variables
$id = $name = $surname = $email = '';
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
} else {
    $errors[] = 'Invalid contact ID';
}

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
        // Check for unique email, excluding current contact
        $existingEmail = fetchOne("SELECT COUNT(*) AS count FROM contacts WHERE email = '$email' AND id != $id");
        if ($existingEmail['count'] > 0) {
            $errors[] = 'Email already exists';
        }
    }

    // If no errors, update the contact in the database
    if (empty($errors)) {
        $query = "UPDATE contacts SET name = '$name', surname = '$surname', email = '$email' WHERE id = $id";
        if (executeQuery($query)) {
            header('Location: index.php');
            exit;
        } else {
            $errors[] = 'Failed to update contact';
        }
    }
}
?>

<h2>Edit Contact</h2>

<?php if (!empty($errors)): ?>
    <ul>
        <?php foreach ($errors as $error): ?>
            <li><?php echo htmlspecialchars($error); ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
<body>
    <div class="container10">

<form action="edit.php?id=<?php echo htmlspecialchars($id); ?>" method="post">
    <div>
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
    </div>
    <div>
        <label for="surname">Surname:</label>
        <input type="text" id="surname" name="surname" value="<?php echo htmlspecialchars($surname); ?>" required>
    </div>
    <div>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
    </div>
    <div>
        <button type="submit">Update Contact</button>
    </div>
</form>
</div>
</body>
