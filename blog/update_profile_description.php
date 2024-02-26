<?php
session_start();
require_once '../includes/dbh.inc.php';

if (isset($_POST['updateDescription']) && isset($_SESSION['userid'])) {
    $userId = $_SESSION['userid']; // Pobranie ID zalogowanego użytkownika
    $newDescription = $_POST['profileDescription']; // Pobranie nowego opisu profilu z formularza

    // Aktualizacja opisu profilu w tabeli users
    $sql = "UPDATE users SET profilOpis = ? WHERE usersId = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        // Jeśli przygotowanie zapytania nie powiedzie się, przekieruj z błędem
        header("Location: ../profile.php?error=sqlerror");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "si", $newDescription, $userId);
    mysqli_stmt_execute($stmt);
    
    header("Location: profile.php?descriptionUpdated");
} else {
    header("Location: profile.php");
}