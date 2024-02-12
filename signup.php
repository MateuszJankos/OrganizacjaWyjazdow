<!DOCTYPE html>
<html>
  <head>
    <title>Logowanie</title>
  </head>
  <body>
  <section class="signup-form">
    <h2>Rejestracja</h2>
    <form action="includes/singup.inc.php" method="post">
        <input type="text" name="name" placeholder="Podaj swoje imie">
        <input type="text" name="email" placeholder="Podaj Email">
        <input type="text" name="uid" placeholder="Nazwa użytkownika">
        <input type="password" name="pwd" placeholder="Hasło">
        <input type="password" name="pwdrepeat" placeholder="Powtorz hasło">
        <button type="submit" name="submit">Zarejestruj sie</button>
    </form>
  </section>
  </body>
</html>