
<?php


// Start the session and check if the user is logged in
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php'); // Redirect to login page if not logged in
    exit();
}

// Logout logic
if (isset($_POST['logout'])) {
    session_destroy(); // Destroy the session
    header('Location: login.php'); // Redirect to login page after logout
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php include 'includes/header.php'; ?>
    <div class="container2">
        <h1>Welcome, <?php echo $_SESSION['username']; ?>!</h1>
        <div class="navigation">
            <ul>
                <li><a href="./clients/index.php">Manage Clients</a></li>
                <li><a href="./contacts/index.php">Manage Contacts</a></li>
                <li>
                    <form method="post" action="">
                        <input type="submit" name="logout" value="Logout">
                    </form>
                </li>
            </ul>
        </div>
    </div>
</body>
</html>
