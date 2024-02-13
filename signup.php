<!DOCTYPE html>
<html>
  <head>
    <title>Logowanie</title>
  </head>
  <body>
  <section class="signup-form">
    <h2>Rejestracja</h2>
    <form action="includes/singup.inc.php" method="post">
        <input type="text" name="name" placeholder="Imie i nazwisko">
        <input type="text" name="email" placeholder="Podaj Email">
        <input type="text" name="uid" placeholder="Nazwa użytkownika">
        <input type="password" name="pwd" placeholder="Hasło">
        <input type="password" name="pwdrepeat" placeholder="Powtorz hasło">
        <button type="submit" name="submit">Zarejestruj sie</button>
    </form>
    <?php
  if (isset($_GET["error"])) {
    if ($_GET["error"] == "emptyinput") {
      echo "<p>Wypełnij wszystkie pola!</p>";
    }
    else if ($_GET["error"] == "invalidUid") {
      echo "<p>Wybierz poprawną nazwę użytkownika!</p>";
    }
    else if ($_GET["error"] == "invalidemail") {
      echo "<p>Podaj poprawny Email!</p>";
    }
    else if ($_GET["error"] == "passwordsdontmatch") {
      echo "<p>Hasła są różne!</p>";
    }
    else if ($_GET["error"] == "usernametaken") {
      echo "<p>Nazwa użytkownika już jest zajęta!</p>";
    }
    else if ($_GET["error"] == "stmtFAIL") {
      echo "<p>Brak połączenia z Bazą danych!</p>";
    }
    else if ($_GET["error"] == "CreationFail") {
      echo "<p>Nie można utworzyć nowego konta!</p>";
    }
    else if ($_GET["error"] == "none") {
      echo "<p>Udało ci się stworzyć konto!</p>";
    }
    }
    ?>
  </section>
  </body>
</html>