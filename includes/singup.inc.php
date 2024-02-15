<?php
// Sprawdzanie, czy formularz został wysłany
if (isset($_POST["submit"])) {
 // Pobiera dane wprowadzone przez użytkownika w formularzu rejestracyjnym   
    $name = $_POST["name"];
    $email = $_POST["email"];
    $username = $_POST["uid"];
    $pwd = $_POST["pwd"];
    $pwdRepeat = $_POST["pwdrepeat"];

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';
//błędy związane z rejestracją, co można zrobić źle
    if (emptyInputSignup($name, $email, $username, $pwd, $pwdRepeat) !== false) {
        header("location: ../signup.php?error=emptyinput");
        exit();
    }
    if (invalidUid($username) !== false) {
        header("location: ../signup.php?error=invaliduid");
        exit();
    }
    if (invalidEmail($email) !== false) {
        header("location: ../signup.php?error=invalidemail");
        exit();
    }
    if (pwdMatch($pwd, $pwdRepeat) !== false) {
        header("location: ../signup.php?error=passwordsdontmatch");
        exit();
    }
    if (uidExists($conn, $username, $email) !== false) {
        header("location: ../signup.php?error=usernametaken");
        exit();
    }
 // Jeśli wszystkie powyższe warunki są spełnione, użytkownik jest rejestrowany w systemie
    createUser($conn, $name, $email, $username, $pwd);

}
else {  // Jeśli formularz nie został wysłany, użytkownik jest przekierowywany do strony rejestracji
    header("location: ../signup.php");
    exit();
}