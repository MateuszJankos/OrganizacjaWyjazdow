<?php
include_once 'ALLheader.php'; // Dołączenie nagłówka strony
require_once '../includes/dbh.inc.php'; // Połączenie z bazą danych

// Sprawdzenie zalogowanego użytkownika
if (isset($_SESSION['userid'])) {
    $userId = $_SESSION['userid'];

    // Zapytanie do bazy danych o grupy, do których należy użytkownik
    $sql = "SELECT grupa.Nazwa_Grupy 
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
}
?>

<div class="container mt-5">
    <h2>Wybierz grupę</h2>
    <form action="" method="post">
        <div class="form-group">
            <label for="groupName">Grupa</label>
            <select class="form-control" id="groupName" name="groupName">
                <?php if (!empty($groups)): ?>
                    <?php foreach ($groups as $group): ?>
                        <option value="<?= htmlspecialchars($group['Nazwa_Grupy']) ?>">
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

    <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['createTrip'])) {
    include 'create_trip.php'; // Dołączenie pliku z logiką tworzenia wyjazdu
}

if ($groupSelected):
?>
    <h3>Stwórz nowy wyjazd w grupie Narty</h3>
    <form action="" method="post">
        <input type="hidden" name="groupName" value="Narty">
        <div class="form-group">
            <label for="destination">Miejsce docelowe</label>
            <input type="text" class="form-control" id="destination" name="destination" required>
        </div>
        <div class="form-group">
            <label for="startDate">Data rozpoczęcia</label>
            <input type="date" class="form-control" id="startDate" name="startDate" required>
        </div>
        <div class="form-group">
            <label for="endDate">Data zakończenia</label>
            <input type="date" class="form-control" id="endDate" name="endDate" required>
        </div>
        <button type="submit" name="createTrip" class="btn btn-success mt-3">Stwórz wyjazd</button>
    </form>
<?php endif; ?>

    <?php if ($tripCreated): ?>
        <div class="alert alert-success mt-3" role="alert">
            Nowy wyjazd do <?= $destination ?> został utworzony! (Data rozpoczęcia: <?= $startDate ?>, Data zakończenia: <?= $endDate ?>)
        </div>
    <?php endif; ?>
</div>

<?php
include_once 'ALLfooter.php'; // Dołączenie stopki strony
?>