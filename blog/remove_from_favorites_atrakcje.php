<?php
session_start();
require_once '../includes/dbh.inc.php';

if (isset($_POST['removeFavoriteAtrakcja']) && isset($_SESSION['userid'])) {
    $userId = $_SESSION['userid'];
    $atraId = $_POST['atraId'];

    // Przygotowanie zapytania SQL do usunięcia atrakcji z ulubionych
    $deleteQuery = "DELETE FROM ulubione_atrakcje WHERE usersId = ? AND atraId = ?";
    $deleteStmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($deleteStmt, $deleteQuery)) {
        echo "Błąd zapytania SQL.";
        exit();
    }
    mysqli_stmt_bind_param($deleteStmt, "ii", $userId, $atraId);
    mysqli_stmt_execute($deleteStmt);

    header("Location: atrakcje.php?favoriteRemoved");
    exit();
} else {
    header("Location: ../index.php");
    exit();
}