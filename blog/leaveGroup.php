<?php
session_start();
require_once '../includes/dbh.inc.php';

if (isset($_POST['leaveGroup']) && isset($_SESSION['userid'])) {
    $groupId = $_POST['groupId'];
    $userId = $_SESSION['userid'];

    // Przygotowanie zapytania SQL do usunięcia rekordu
    $sql = "DELETE FROM uczestnik_grupy WHERE usersId = ? AND ID_Grupy = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("ii", $userId, $groupId);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            echo "Pomyślnie opuszczono grupę.";
        } else {
            echo "Nie udało się opuścić grupy lub użytkownik nie jest jej członkiem.";
        }
        $stmt->close();
    } else {
        echo "Błąd podczas przygotowywania zapytania: " . $conn->error;
    }
    // Możesz tutaj dodać przekierowanie do poprzedniej strony
    header('Location: grupy.php');
    exit();
} else {
    // Przekierowanie użytkownika, jeśli nie jest zalogowany lub nie wysłał formularza
    header('Location: index.php');
    exit();
}