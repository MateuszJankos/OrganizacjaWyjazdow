<?php
// Database configuration
$host = 'localhost';
$dbname = 'my_app';
$username = 'root';
$password = '';
$dsn = "mysql:host=$host;dbname=$dbname";

try {
    $conn = new PDO($dsn, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_POST['register'])) {
        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $age = $_POST['age'];
        $pass = $_POST['password'];
        $confirmPass = $_POST['confirm_password'];
        $terms = $_POST['terms'] ?? null;

        // Validate input and check if passwords match
        if ($pass !== $confirmPass) {
            echo "Passwords do not match.";
            exit;
        }
        if (!$terms) {
            echo "You must accept the terms and conditions.";
            exit;
        }

        // Hash the password
        $hashedPass = password_hash($pass, PASSWORD_DEFAULT);

        // Insert the user into the database
        $stmt = $conn->prepare("INSERT INTO users (name, surname, age, password) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $surname, $age, $hashedPass]);

        echo "Registration successful.";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
