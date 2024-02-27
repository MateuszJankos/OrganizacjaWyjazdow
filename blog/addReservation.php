<?php
session_start();
require_once '../includes/dbh.inc.php'; // Dołączenie pliku połączenia z bazą danych

// Sprawdzenie, czy użytkownik jest zalogowany
if (!isset($_SESSION['userid'])) {
    header("Location: login.php"); // Przekierowanie do strony logowania
    exit();
}

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO rezerwacja_hotelu (ID_Wyjazdu, hotelId, Data_start_rezerwacji, Data_koniec_rezerwacji, Opis_pokoju) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("iisss", $ID_Wyjazdu, $hotelId, $Data_Start_rezerwacji, $Data_koniec_rezerwacji, $Opis_pokoju);

// Set parameters and execute
$ID_Wyjazdu = $_POST['ID_Wyjazdu'];
$hotelId = $_POST['hotelId'];
$Data_Start_rezerwacji = $_POST['Data_Start_rezerwacji'];
$Data_koniec_rezerwacji = $_POST['Data_koniec_rezerwacji'];
$Opis_pokoju = $_POST['Opis_pokoju'];

if ($stmt->execute()) {
    echo "Reservation successfully added.";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();