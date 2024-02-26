<?php
session_start();
require_once '../includes/dbh.inc.php';

if (isset($_POST['addFavoriteHotel']) && isset($_SESSION['userid'])) {
    $userId = $_SESSION['userid'];
    $hotelId = $_POST['hotelId'];

    // Sprawdzenie, czy ten hotel już jest w ulubionych tego użytkownika
    $checkSql = "SELECT * FROM ulubione_hotele WHERE usersId = ? AND hotelId = ?";
    $checkStmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($checkStmt, $checkSql)) {
        header("Location: hotel.php?error=sqlerror");
        exit();
    }

    mysqli_stmt_bind_param($checkStmt, "ii", $userId, $hotelId);
    mysqli_stmt_execute($checkStmt);
    $checkResult = mysqli_stmt_get_result($checkStmt);

    if (mysqli_fetch_assoc($checkResult)) {
        // Ten hotel już jest w ulubionych, nie trzeba nic robić
        header("Location: hotel.php?error=alreadyinfavorites");
        exit();
    } else {
        // Hotelu nie ma w ulubionych, więc dodajemy
        $insertSql = "INSERT INTO ulubione_hotele (usersId, hotelId) VALUES (?, ?)";
        $insertStmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($insertStmt, $insertSql)) {
            header("Location: hotel.php?error=sqlerror");
            exit();
        }

        mysqli_stmt_bind_param($insertStmt, "ii", $userId, $hotelId);
        mysqli_stmt_execute($insertStmt);

        header("Location: hotel.php?favoriteAdded");
        exit();
    }
} else {
    header("Location: hotel.php?error=notloggedin");
    exit();
}