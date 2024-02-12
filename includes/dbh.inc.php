<?php
//Połączenie z bazą danych
$serverName = "localhost";
$dBUsername = "root";
$dBPassword = "";
$dBName = "wyjazdy";

$conn = mysqli_connect($serverName, $dBUsername, $dBPassword, $dBName);
//jeśli się nie połączy to wyrzuca błąd
if (!$conn) {
    die("Utrata połączenia: " . mysqli_connect_error());
}
