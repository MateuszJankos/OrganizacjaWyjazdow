<?php
// Połączenie z bazą danych
$host = "localhost";
$db_user = "twoj_uzytkownik";
$db_password = "twoje_haslo";
$db_name = "twoja_baza_danych";

$conn = new mysqli($host, $db_user, $db_password, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Pobranie danych z formularza
$email = $_POST['email'];
$password = $_POST['password'];

// Wstawienie danych do bazy
$sql = "INSERT INTO uzytkownicy (email, haslo) VALUES ('$email', '$password')";

if ($conn->query($sql) === TRUE) {
    echo "Rekord został dodany poprawnie";
} else {
    echo "Błąd: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
