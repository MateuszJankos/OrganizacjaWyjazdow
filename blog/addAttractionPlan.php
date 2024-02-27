<?php
session_start();
require_once '../includes/dbh.inc.php'; // Include database connection

// Check if user is logged in
if (!isset($_SESSION['userid'])) {
    header("Location: login.php"); // Redirect to login page if user is not logged in
    exit();
}

// Prepare and bind parameters
$stmt = $conn->prepare("INSERT INTO planowanie_atrakcji (atraId, ID_Wyjazdu, Data_wizyty) VALUES (?, ?, ?)");
$stmt->bind_param("iis", $atraId, $ID_Wyjazdu, $Data_wizyty);

// Set parameters and execute
$atraId = $_POST['atraId'];
$ID_Wyjazdu = $_POST['ID_Wyjazdu'];
$Data_wizyty = $_POST['Data_wizyty'];

if ($stmt->execute()) {
    echo "Planowanie atrakcji zostało pomyślnie dodane.";
} else {
    echo "Błąd: " . $stmt->error;
}

// Close statement and database connection
$stmt->close();
$conn->close();