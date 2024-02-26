<?php
session_start();
require_once '../includes/dbh.inc.php';

if (isset($_POST['removeFavoriteHotel']) && isset($_SESSION['userid'])) {
    $userId = $_SESSION['userid']; // Pobranie ID zalogowanego użytkownika
    $hotelId = $_POST['hotelId']; // Pobranie ID hotelu z formularza

    // Usuwanie hotelu z ulubionych
    $sql = "DELETE FROM ulubione_hotele WHERE usersId = ? AND hotelId = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        // Jeśli przygotowanie zapytania nie powiedzie się, przekieruj z błędem
        header("Location: hotel.php?error=sqlerror");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ii", $userId, $hotelId);
    mysqli_stmt_execute($stmt);

    // Sprawdzanie, czy zapytanie rzeczywiście coś usunęło
    if (mysqli_stmt_affected_rows($stmt) > 0) {
        // Przekierowanie z powrotem na stronę hoteli z komunikatem o sukcesie
        header("Location: hotel.php?favoriteRemoved=true");
    } else {
        // Przekierowanie z powrotem na stronę hoteli z komunikatem o błędzie
        header("Location: hotel.php?error=notinfavorites");
    }
    exit();
} else {
    // Jeśli użytkownik nie jest zalogowany lub formularz nie został poprawnie przesłany
    header("Location: hotel.php?error=notloggedin");
    exit();
}