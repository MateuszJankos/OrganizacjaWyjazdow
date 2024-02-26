<?php
session_start();
require_once '../includes/dbh.inc.php';

if (isset($_POST['addFavoriteAtrakcja']) && isset($_SESSION['userid'])) {
    $userId = $_SESSION['userid'];
    $atraId = $_POST['atraId'];

    // Sprawdzenie, czy atrakcja nie jest już dodana do ulubionych
    $checkQuery = "SELECT * FROM ulubione_atrakcje WHERE usersId = ? AND atraId = ?";
    $checkStmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($checkStmt, $checkQuery)) {
        echo "Błąd zapytania SQL.";
        exit();
    }
    mysqli_stmt_bind_param($checkStmt, "ii", $userId, $atraId);
    mysqli_stmt_execute($checkStmt);
    $checkResult = mysqli_stmt_get_result($checkStmt);

    if ($checkResult->num_rows == 0) {
        // Atrakcja nie jest w ulubionych, dodaj ją
        $insertQuery = "INSERT INTO ulubione_atrakcje (usersId, atraId) VALUES (?, ?)";
        $insertStmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($insertStmt, $insertQuery)) {
            echo "Błąd zapytania SQL.";
            exit();
        }
        mysqli_stmt_bind_param($insertStmt, "ii", $userId, $atraId);
        mysqli_stmt_execute($insertStmt);

        echo "Atrakcja została dodana do ulubionych.";
    }
    
    header("Location: atrakcje.php?favoriteAdded");
    exit();
} else {
    header("Location: atrakcje.php?error=notloggedin");
    exit();
}