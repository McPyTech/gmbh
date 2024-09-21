<?php
session_start();

// Database connection settings
$servername = getenv('DB_SERVERNAME') ?: 'localhost';
$dbname = getenv('DB_NAME') ?: 'mydatabase';
$dbusername = getenv('DB_USERNAME') ?: 'root';
$dbpassword = getenv('DB_PASSWORD') ?: 'password';

// Create connection
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
$conn->set_charset("utf8mb4");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the submitted username and password
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);

    // Prepare and bind
    $stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    // Check if the user exists
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($hashed_password);
        $stmt->fetch();

        // Verify the password
        if (password_verify($password, $hashed_password)) {
            // Set session variables
            $_SESSION['username'] = $username;
            $_SESSION['loggedin'] = true;

            // Redirect to a protected page
            header('Location: protected_page.php');
            exit;
        } else {
            // Invalid credentials
            $error_message = 'Invalid username or password';
        }
    } else {
        // Invalid credentials
        $error_message = 'Invalid username or password';
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Business Login</title>
    <link rel="stylesheet" href="path/to/your/business-template.css">
</head>
<body>
    <div class="business-container">
        <header>
            <h1>Welcome to Our Business</h1>
        </header>
        <main>
            <div class="login-container">
                <h2>Login</h2>
                <?php if (!empty($error_message)): ?>
                    <div class="error-message"><?php echo $error_message; ?></div>
                <?php endif; ?>
                <form action="login.php" method="post">
                    <input type="text" name="username" placeholder="Username" required>
                    <input type="password" name="password" placeholder="Password" required>
                    <input type="submit" value="Login">
                </form>
            </div>
        </main>
        <footer>
            <p>&copy; 2023 Our Business. All rights reserved.</p>
        </footer>
    </div>
</body>
</html>
