<?php
// Sprawdzanie, czy formularz został wysłany
if (isset($_POST["submit"])) {
// Przypisywanie danych z formularza do zmiennych
    $username = $_POST["uid"];
    $pwd = $_POST["pwd"];
// Dołączanie plików z funkcjami i połączeniem z bazą danych
    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';
// Jeśli pola są puste, przekierowanie do strony logowania z komunikatem błędu
    if (emptyInputLogin($username, $pwd) !== false) {
        header("location: ../login.php?error=emptyinput");
        exit();
    }

    loginUser($conn, $username, $pwd);
}
else { // Przekierowanie do strony logowania, jeśli formularz nie został wysłany
    header("location: ../login.php");
    exit();
}