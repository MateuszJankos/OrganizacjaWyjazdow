<?php
session_start();
// Sprawdź, czy wszystkie pola zostały wypełnione
if (isset($_POST['destination'], $_POST['startDate'], $_POST['endDate'])) {
    // Pobierz dane z formularza
    $destination = $_POST['destination'];
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];

    // Połącz z bazą danych
    require_once 'db_connection.php'; // Zmień na właściwą ścieżkę do pliku połączenia z bazą

    // Przygotuj zapytanie do bazy danych
    $sql = "INSERT INTO wyjazd (Data_Startu, Data_Konca, ID_Grupy) VALUES (?, ?, (SELECT ID_Grupy FROM grupa WHERE Nazwa_Grupy = ?))";
    if ($stmt = $conn->prepare($sql)) {
        // Pobierz ID grupy na podstawie nazwy grupy, w tym przypadku 'Narty'
        $groupName = 'Narty';
        // Bind parametrów do zapytania
        $stmt->bind_param('sss', $startDate, $endDate, $groupName);
        // Wykonaj zapytanie
        if ($stmt->execute()) {
            $tripCreated = true;
        } else {
            echo "Błąd przy tworzeniu wyjazdu: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Błąd: " . $conn->error;
    }
    $conn->close();
}
