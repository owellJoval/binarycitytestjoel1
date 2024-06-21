
<?php
session_start();

if (isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate login credentials (replace with actual validation logic)
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if username and password are valid (example)
    if ($username === 'admin' && $password === 'password123') {
        $_SESSION['username'] = $username;
        header('Location: index.php');
        exit();
    } else {
        $error = "Invalid username or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .form-container {
            max-width: 400px;
            margin: auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .form-container img.logo {
            max-width: 100px;
            margin-bottom: 20px;
        }

        .form-container h1 {
            margin-bottom: 20px;
        }

        .form-container .error {
            color: red;
            margin-bottom: 10px;
        }

        .form-container label {
            display: block;
            margin-bottom: 10px;
            text-align: left;
        }

        .form-container input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .form-container button {
            width: 100%;
            padding: 12px;
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .form-container button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
   
    

    <div class="container">
        <div class="form-container">
            <img src="./images/logo.png" alt="Logo" class="logo">
            <h1>Login</h1>
            <p>Test Joel Chipoya</p>
            <?php if (isset($error)) : ?>
                <div class="error"><?php echo $error; ?></div>
            <?php endif; ?>
            <form action="login.php" method="POST">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required><br>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required><br>
                <button type="submit">Login</button>
            </form>
        </div>
    </div>

    
</body>

</html>
