<?php
session_start();
require_once '../includes/dbh.inc.php'; // Dołączenie pliku połączenia z bazą danych

// Sprawdzenie, czy użytkownik jest zalogowany
if (!isset($_SESSION['userid'])) {
    header("Location: login.php"); // Przekierowanie do strony logowania
    exit();
}

// Sprawdzenie, czy formularz został przesłany
if (isset($_POST['addMessage'])) {
    $Tresc = $_POST['Tresc'];
    $ID_Wyjazdu = $_POST['ID_Wyjazdu'];
    $userId = $_SESSION['userid'];

    // Walidacja danych wejściowych (możesz dodać bardziej szczegółową walidację)
    if (empty($Tresc) || empty($ID_Wyjazdu)) {
        // Obsługa błędu, gdy jakiekolwiek pole jest puste
        header("Location: message.php?error=emptyfields");
        exit();
    }

    // Zapytanie do bazy danych
    $sql = "INSERT INTO wiadomosc (Tresc, Data_Wyslania, ID_Wyjazdu, ID_Nadawcy) VALUES (?, NOW(), ?, ?)";

    // Przygotowanie zapytania
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        // Obsługa błędu przygotowania zapytania
        header("Location: message.php?error=sqlerror");
        exit();
    }

    // Przypisanie parametrów do zapytania
    $stmt->bind_param("sii", $Tresc, $ID_Wyjazdu, $userId);

    // Wykonanie zapytania
    $stmt->execute();

    if ($stmt->affected_rows === 0) {
        // Obsługa błędu, gdy nie dodano wiadomości
        header("Location: message.php?error=messagefailed");
        exit();
    } else {
        // Przekierowanie do strony z potwierdzeniem
        header("Location: message.php?success=messageadded");
    }

    // Zamknięcie zapytania
    $stmt->close();
}