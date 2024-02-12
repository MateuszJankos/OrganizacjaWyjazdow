<?php

if (isset($_POST["submit"])) {
    echo "Dziala poprawnie";
}
else {
    header("location: ../signup.php");
}