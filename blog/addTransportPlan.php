<?php
session_start();
require_once '../includes/dbh.inc.php'; // Include database connection

// Check if user is logged in
if (!isset($_SESSION['userid'])) {
    header("Location: login.php"); // Redirect to login page if user is not logged in
    exit();
}

// Prepare and bind parameters
$stmt = $conn->prepare("INSERT INTO planowanie_transportu (ID_Wyjazdu, ID_Rodzaju_Transportu, Pozycja_startowa, Pozycja_koncowa, Data_startowa, Data_koncowa, Kategoria_transportu, Cena) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("iisssssd", $ID_Wyjazdu, $ID_Rodzaju_Transportu, $Pozycja_startowa, $Pozycja_koncowa, $Data_startowa, $Data_koncowa, $Kategoria_transportu, $Cena);

// Set parameters and execute
$ID_Wyjazdu = $_POST['ID_Wyjazdu'];
$ID_Rodzaju_Transportu = $_POST['ID_Rodzaju_Transportu'];
$Pozycja_startowa = $_POST['Pozycja_startowa'];
$Pozycja_koncowa = $_POST['Pozycja_koncowa'];
$Data_startowa = $_POST['Data_startowa'];
$Data_koncowa = $_POST['Data_koncowa'];
$Kategoria_transportu = $_POST['Kategoria_transportu'];
$Cena = $_POST['Cena'];

if ($stmt->execute()) {
    echo "Planowanie transportu zostało pomyślnie dodane.";
} else {
    echo "Błąd: " . $stmt->error;
}

// Close statement and database connection
$stmt->close();
$conn->close();