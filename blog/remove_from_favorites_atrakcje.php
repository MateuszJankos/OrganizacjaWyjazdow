<?php
session_start();
require_once '../includes/dbh.inc.php';

if (isset($_POST['removeFavoriteAtrakcja']) && isset($_SESSION['userid'])) {
    $userId = $_SESSION['userid'];
    $atraIdToRemove = $_POST['atraId'];

    // Pobierz aktualną listę ulubionych atrakcji
    $sql = "SELECT profilUluatra FROM profil WHERE usersId = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $favorites = explode(',', $row['profilUluatra']);
        if (($key = array_search($atraIdToRemove, $favorites)) !== false) {
            unset($favorites[$key]);
        }

        // Aktualizuj profil z nową listą ulubionych atrakcji
        $newFavorites = implode(',', $favorites);
        $updateSql = "UPDATE profil SET profilUluatra = ? WHERE usersId = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("si", $newFavorites, $userId);
        $updateStmt->execute();
    }

    header("Location: atrakcje.php?favoriteRemoved");
    exit();
} else {
    header("Location: ../index.php");
    exit();
}