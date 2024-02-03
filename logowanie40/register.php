<?php
// Database configuration
$host = 'localhost'; // or your database host
$dbname = 'your_database_name';
$username = 'your_database_username';
$password = 'your_database_password';
$dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";

try {
    // Create a new PDO instance
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Retrieve data from form
        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $age = $_POST['age'];
        $username = $_POST['username']; // Ensure you have a 'username' field in your form
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirm_password'];

        // Basic validation (make sure to improve this for production use)
        if ($password !== $confirmPassword) {
            echo "Passwords do not match.";
            exit;
        } else {
            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Prepare SQL statement
            $sql = "INSERT INTO users (name, surname, age, username, password) VALUES (?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$name, $surname, $age, $username, $hashedPassword]);

            // Redirect to index.html upon successful registration
            header('Location: index.html');
            exit;
        }
    }
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
    exit;
}
?>