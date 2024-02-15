<?php
// Niszczy sesję - usuwa sesję z serwera
session_start();
session_unset();
session_destroy();
// Przekierowuje użytkownika do głównej strony bloga
header("location: ../blog/index.php");
exit();