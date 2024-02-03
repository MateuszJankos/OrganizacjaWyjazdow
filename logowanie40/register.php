<?php
// Database configuration
$host = 'localhost';
$dbname = 'my_app_db'; // Make sure to use the correct database name
$username = 'root'; // Default username for localhost
$password = ''; // Default password for localhost (empty)
$dsn = "mysql:host=$host;dbname=$dbname";

try {
    // Create a PDO instance as db connection
    $conn = new PDO($dsn, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_POST['register'])) {
        // Retrieve user input from the form
        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $age = $_POST['age'];
        $username = $_POST['username']; // Make sure to add a username field in your form
        $pass = $_POST['password'];
        $confirmPass = $_POST['confirm_password'];

        // Basic validation (additional validation is recommended)
        if ($pass !== $confirmPass) {
            echo "Passwords do not match.";
            exit;
        }

        // Hash the password
        $hashedPass = password_hash($pass, PASSWORD_DEFAULT);

        // Prepare SQL statement to insert the new user
        $sql = "INSERT INTO users (name, surname, age, username, password) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        
        // Execute the statement with user input
        $stmt->execute([$name, $surname, $age, $username, $hashedPass]);

        // Redirect to login page after successful registration
        header("Location: index.html");
        exit;
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>