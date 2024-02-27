<?php
require_once '../includes/dbh.inc.php'; // Połączenie z bazą danych

// Sprawdzanie, czy skrypt został wywołany przez wysłanie formularza
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['createTrip'])) {
    // Przypisanie danych z formularza do zmiennych
    $groupName = $_POST['groupName'];
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];

    // Wyszukanie ID_Grupy na podstawie nazwy grupy
    $groupSql = "SELECT ID_Grupy FROM grupa WHERE Nazwa_Grupy = ?";
    if ($stmt = $conn->prepare($groupSql)) {
        $stmt->bind_param("s", $groupName);
        $stmt->execute();
        $result = $stmt->get_result();
        $groupRow = $result->fetch_assoc();
        $groupId = $groupRow['ID_Grupy'];
    } else {
        // Obsługa błędów zapytania
        die("Błąd zapytania do bazy danych: " . $conn->error);
    }

    // Dodanie wyjazdu do bazy danych
    $tripSql = "INSERT INTO wyjazd (Data_Startu, Data_Konca, ID_Grupy) VALUES (?, ?, ?)";
    if ($stmt = $conn->prepare($tripSql)) {
        $stmt->bind_param("ssi", $startDate, $endDate, $groupId);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "Nowy wyjazd został dodany.";
        } else {
            echo "Nie udało się dodać nowego wyjazdu.";
        }
    } else {
        // Obsługa błędów zapytania
        die("Błąd zapytania do bazy danych: " . $conn->error);
    }
}