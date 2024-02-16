<?php
session_start();
require_once '../includes/dbh.inc.php';
if (isset($_POST['addFavorite']) && isset($_SESSION['userid'])) {

    $userId = $_SESSION['userid']; // Pobranie ID zalogowanego użytkownika
    $hotelId = $_POST['hotelId']; // Pobranie ID hotelu z formularza

    // Sprawdzenie, czy użytkownik już ma profil
    $sql = "SELECT profilUluhotel FROM profil WHERE usersId = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: hotel.php?error=sqlerror");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "i", $userId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        // Użytkownik ma już profil, aktualizujemy ulubione hotele
        $favorites = $row['profilUluhotel'];
        $favoritesArray = $favorites ? explode(',', $favorites) : [];

        if (!in_array($hotelId, $favoritesArray)) {
            array_push($favoritesArray, $hotelId);
            $newFavorites = implode(',', $favoritesArray);

            // Aktualizacja listy ulubionych hoteli użytkownika
            $updateSql = "UPDATE profil SET profilUluhotel = ? WHERE usersId = ?";
            $updateStmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($updateStmt, $updateSql)) {
                header("Location: hotel.php?error=sqlerror");
                exit();
            }

            mysqli_stmt_bind_param($updateStmt, "si", $newFavorites, $userId);
            mysqli_stmt_execute($updateStmt);
        }
    } else {
        // Użytkownik nie ma profilu, tworzymy nowy rekord
        $newFavorites = $hotelId;
        $insertSql = "INSERT INTO profil (usersId, profilUluhotel) VALUES (?, ?)";
        $insertStmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($insertStmt, $insertSql)) {
            header("Location: hotel.php?error=sqlerror");
            exit();
        }
        mysqli_stmt_bind_param($insertStmt, "is", $userId, $newFavorites);
        mysqli_stmt_execute($insertStmt);
    }

    header("Location: hotel.php?favoriteAdded");
    exit();
} else {
    header("Location: hotel.php?error=notloggedin");
    exit();
}