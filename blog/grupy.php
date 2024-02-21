<?php
include_once 'ALLheader.php'; // Dołączenie nagłówka strony
require_once '../includes/dbh.inc.php'; // Połączenie z bazą danych

if (isset($_POST['createGroup'])) {
    $groupName = htmlspecialchars($_POST['groupName']);
    $groupDescription = htmlspecialchars($_POST['groupDescription']);

    // Prepare and execute statement to prevent SQL injection
    $stmt = $pdo->prepare("INSERT INTO groups (name, description) VALUES (?, ?)");
    $stmt->execute([$groupName, $groupDescription]);

    // Redirect or give feedback here after saving to database
    // header('Location: grupy.php'); // Uncomment to redirect to the same page
    // exit();
}
?>

<main class="container">
    <h2>Utwórz nową grupę</h2>
    <form action="" method="post">
        <div class="form-group">
            <label for="groupName">Nazwa grupy</label>
            <input type="text" class="form-control" id="groupName" name="groupName" required>
        </div>
        <div class="form-group">
            <label for="groupDescription">Opis grupy</label>
            <textarea class="form-control" id="groupDescription" name="groupDescription" required></textarea>
        </div>
        <button type="submit" name="createGroup" class="btn btn-primary">Utwórz grupę</button>
    </form>

    <main class="container">
    <!-- Other content above... -->

    <h3>Moje grupy</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Nazwa grupy</th>
                <th>Liczba uczestników</th>
                <th>Opis grupy</th>
                <th>Akcje</th>
            </tr>
        </thead>
        <tbody>
            <!-- Statically defined group entry -->
            <tr>
                <td>Narty</td>
                <td>4</td>
                <td>Wyjazdy w góry na ferie</td>
                <td><button class="btn btn-danger">Odejdź z grupy</button></td>
            </tr>
            <!-- Additional group entries would be added here -->
        </tbody>
    </table>
</main>


<?php
include_once 'ALLfooter.php'; // Dołączenie stopki strony
?>