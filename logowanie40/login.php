<?php
session_start();
// Database configuration
$host = 'localhost';
$dbname = 'my_app';
$username = 'root';
$password = '';
$dsn = "mysql:host=$host;dbname=$dbname";

try {
    $conn = new PDO($dsn, $username, $password);
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_POST['login'])) {
        $user = $_POST['username'];
        $pass = $_POST['password'];

        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$user]);
        $user = $stmt->fetch();

        if ($user && password_verify($pass, $user['password'])) {
            $_SESSION['user'] = $user['username'];
            // Redirect to a secure page
            header("Location: dashboard.php");
        } else {
            echo "Invalid username or password";
        }
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
