<?php
session_start();
require_once '../includes/dbh.inc.php';

if (isset($_POST['removeFavorite']) && isset($_SESSION['userid'])) {
    $userId = $_SESSION['userid'];
    $hotelIdToRemove = $_POST['hotelId'];

    // Pobierz aktualną listę ulubionych hoteli
    $sql = "SELECT profilUluhotel FROM profil WHERE usersId = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $favorites = explode(',', $row['profilUluhotel']);
        if (($key = array_search($hotelIdToRemove, $favorites)) !== false) {
            unset($favorites[$key]);
        }

        // Aktualizuj profil z nową listą ulubionych hoteli
        $newFavorites = implode(',', $favorites);
        $updateSql = "UPDATE profil SET profilUluhotel = ? WHERE usersId = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("si", $newFavorites, $userId);
        $updateStmt->execute();
    }

    header("Location: hotel.php?favoriteRemoved");
    exit();
} else {
    header("Location: ../index.php");
    exit();
}