<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Logowanie</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <style>
  body {
    background: linear-gradient(to right, #0c338e, #12537c); /* Błękitno gradient dla tła */
    color: #fff; /* Biały tekst */
  }
  .signup-form {
    max-width: 400px;
    margin: auto;
    padding: 20px;
    background: linear-gradient(to right, #0c338e, #12537c); /* Granatowo-niebieski gradient dla okna logowania */
    border-radius: 15px; /* Zaokrąglenie rogów */
    color: #ffec41; /* Zmiana koloru tekstu na biały */
  }
  .form-control {
    background-color: rgba(255,255,255,0.1); /* Lekko przezroczysty kolor tła dla pól formularza */
    border: none;
    color: #ffec41; /* Biały tekst w polach formularza */
    border-bottom: 1px solid #ffec41; /* Biała linia na dole pola formularza */
  }
  .btn-primary {
    background-color: #0056b3;
    border: none;
    color: #ffec41;
  }
  .btn-primary:hover {
    background-color: #004085;
  }
</style>

</head>
<body>
  <section class="signup-form my-5">
    <h2 class="text-center">Logowanie</h2>
    <form action="includes/login.inc.php" method="post" class="mt-4">
      <div class="form-group">
        <input type="text" name="uid" placeholder="Nazwa użytkownika/Email" class="form-control">
      </div>
      <div class="form-group">
        <input type="password" name="pwd" placeholder="Hasło" class="form-control">
      </div>
      <div class="text-center">
        <button type="submit" name="submit" class="btn btn-primary">Zaloguj się</button>
      </div>
    </form>
    <?php
    if (isset($_GET["error"])) {
      if ($_GET["error"] == "emptyinput") {
        echo "<p class='text-center mt-3'>Wypełnij wszystkie pola!</p>";
      } else if ($_GET["error"] == "wronglogin") {
        echo "<p class='text-center mt-3'>Niepoprawne dane!</p>";
      }
    }
    ?>
  </section>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>