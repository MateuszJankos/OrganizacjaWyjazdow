<?php
include_once 'ALLheader.php'; // Dołączenie nagłówka strony
require_once '../includes/dbh.inc.php'; // Połączenie z bazą danych

$groupSelected = false; // Zmienna do śledzenia, czy grupa została wybrana

// Sprawdzenie zalogowanego użytkownika
if (isset($_SESSION['userid'])) {
    $userId = $_SESSION['userid'];

    // Zapytanie do bazy danych o grupy, do których należy użytkownik
    $sql = "SELECT grupa.Nazwa_Grupy, grupa.ID_Grupy 
            FROM uczestnik_grupy 
            JOIN grupa ON uczestnik_grupy.ID_Grupy = grupa.ID_Grupy 
            WHERE uczestnik_grupy.usersId = ?";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $groups = $result->fetch_all(MYSQLI_ASSOC);
    } else {
        // Obsługa błędów zapytania
        echo "Błąd zapytania do bazy danych: " . $conn->error;
    }

    // Sprawdzenie, czy formularz wyboru grupy został wysłany
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['selectGroup'])) {
        // Zapisanie wybranego ID_Grupy w sesji
        $_SESSION['selectedGroupId'] = $_POST['groupId'];
        $groupSelected = true; // Ustawienie zmiennej na true, ponieważ grupa została wybrana
    }
}
?>

<div class="container mt-5">
    <h2>Wybierz grupę</h2>
    <form action="" method="post">
        <div class="form-group">
            <label for="groupId">Grupa</label>
            <select class="form-control" id="groupId" name="groupId">
                <?php if (!empty($groups)): ?>
                    <?php foreach ($groups as $group): ?>
                        <option value="<?= htmlspecialchars($group['ID_Grupy']) ?>">
                            <?= htmlspecialchars($group['Nazwa_Grupy']) ?>
                        </option>
                    <?php endforeach; ?>
                <?php else: ?>
                    <option value="">Nie należysz do żadnych grup</option>
                <?php endif; ?>
            </select>
        </div>
        <button type="submit" name="selectGroup" class="btn btn-primary mt-3">Wybierz grupę</button>
    </form>

    <?php if ($groupSelected): ?>
        <?php include 'create_trip_form.php'; // Dołączenie formularza do tworzenia wyjazdu ?>
    <?php endif; ?>
</div>

<?php
include_once 'ALLfooter.php'; // Dołączenie stopki strony
?>