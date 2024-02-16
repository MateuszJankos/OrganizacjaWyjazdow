<?php
session_start();
require_once '../includes/dbh.inc.php';

if (isset($_POST['addFavoriteAtrakcja']) && isset($_SESSION['userid'])) {

    $userId = $_SESSION['userid']; // Pobranie ID zalogowanego użytkownika
    $atraId = $_POST['atraId']; // Pobranie ID atrakcji z formularza

    // Sprawdzenie, czy użytkownik już ma ulubione atrakcje
    $sql = "SELECT profilUluatra FROM profil WHERE usersId = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: atrakcje.php?error=sqlerror");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "i", $userId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        // Użytkownik ma już profil, aktualizujemy ulubione atrakcje
        $favorites = $row['profilUluatra'];
        $favoritesArray = $favorites ? explode(',', $favorites) : [];

        if (!in_array($atraId, $favoritesArray)) {
            array_push($favoritesArray, $atraId);
            $newFavorites = implode(',', $favoritesArray);

            // Aktualizacja listy ulubionych atrakcji użytkownika
            $updateSql = "UPDATE profil SET profilUluatra = ? WHERE usersId = ?";
            $updateStmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($updateStmt, $updateSql)) {
                header("Location: atrakcje.php?error=sqlerror");
                exit();
            }

            mysqli_stmt_bind_param($updateStmt, "si", $newFavorites, $userId);
            mysqli_stmt_execute($updateStmt);
        }
    } else {
        // Użytkownik nie ma profilu, tworzymy nowy rekord z ulubionymi atrakcjami
        $newFavorites = $atraId;
        $insertSql = "INSERT INTO profil (usersId, profilUluatra) VALUES (?, ?)";
        $insertStmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($insertStmt, $insertSql)) {
            header("Location: atrakcje.php?error=sqlerror");
            exit();
        }
        mysqli_stmt_bind_param($insertStmt, "is", $userId, $newFavorites);
        mysqli_stmt_execute($insertStmt);
    }

    header("Location: atrakcje.php?favoriteAdded");
    exit();
} else {
    header("Location: atrakcje.php?error=notloggedin");
    exit();
}