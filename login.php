<!DOCTYPE html>
<html>
  <head>
    <title>Logowanie</title>
  </head>
  <body>
  <section class="signup-form">
    <h2>Logowanie</h2>
    <form action="includes/login.inc.php" method="post">
        <input type="text" name="name" placeholder="Nazwa uzytkownika/Email">
        <input type="password" name="pwd" placeholder="Haslo">
        <button type="submit" name="submit">Zaloguj sie</button>
    </form>
    <?php
  if (isset($_GET["error"])) {
    if ($_GET["error"] == "emptyinput") {
      echo "<p>Wypełnij wszystkie pola!</p>";
    }
    else if ($_GET["error"] == "wronglogin") {
      echo "<p>Niepoprawny Dane!</p>";
    }
    }
    ?>
  </section>
  </body>
</html>