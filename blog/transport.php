<?php
include_once 'ALLheader.php'; // Dołączenie nagłówka strony
require_once '../includes/dbh.inc.php'; // Połączenie z bazą danych

// Sprawdzenie zalogowanego użytkownika
if (isset($_SESSION['userid'])) {
    $userId = $_SESSION['userid'];

    // Pobranie dostępnych rodzajów transportu
    $transportTypesQuery = "SELECT ID_Rodzaju_Transportu, Nazwa_transportu FROM rodzaje_transportu";
    $transportTypesResult = $conn->query($transportTypesQuery);
    $transportTypes = $transportTypesResult->fetch_all(MYSQLI_ASSOC);

    // Pobranie wyjazdów powiązanych z grupami, do których należy użytkownik
    $tripsQuery = "SELECT wyjazd.ID_Wyjazdu, wyjazd.Data_Startu FROM wyjazd
                   JOIN uczestnik_grupy ON wyjazd.ID_Grupy = uczestnik_grupy.ID_Grupy
                   WHERE uczestnik_grupy.usersId = ?";
    $stmt = $conn->prepare($tripsQuery);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $tripsResult = $stmt->get_result();
    $trips = $tripsResult->fetch_all(MYSQLI_ASSOC);
}
?>

<div class="container mt-5">
    <h2>Planowanie transportu</h2>
    <form action="addTransportPlan.php" method="post">
        <div class="form-group">
            <label for="ID_Rodzaju_Transportu">Rodzaj transportu</label>
            <select class="form-control" id="ID_Rodzaju_Transportu" name="ID_Rodzaju_Transportu" required>
                <?php foreach ($transportTypes as $transportType): ?>
                    <option value="<?= htmlspecialchars($transportType['ID_Rodzaju_Transportu']) ?>"><?= htmlspecialchars($transportType['Nazwa_transportu']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="ID_Wyjazdu">Wyjazd</label>
            <select class="form-control" id="ID_Wyjazdu" name="ID_Wyjazdu" required>
                <?php foreach ($trips as $trip): ?>
                    <option value="<?= htmlspecialchars($trip['ID_Wyjazdu']) ?>"><?= htmlspecialchars($trip['Data_Startu']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="Pozycja_startowa">Pozycja startowa</label>
            <input type="text" class="form-control" id="Pozycja_startowa" name="Pozycja_startowa" required>
        </div>
        <div class="form-group">
            <label for="Pozycja_koncowa">Pozycja końcowa</label>
            <input type="text" class="form-control" id="Pozycja_koncowa" name="Pozycja_koncowa" required>
        </div>
        <div class="form-group">
            <label for="Data_startowa">Data startowa</label>
            <input type="date" class="form-control" id="Data_startowa" name="Data_startowa" required>
        </div>
        <div class="form-group">
            <label for="Data_koncowa">Data końcowa</label>
            <input type="date" class="form-control" id="Data_koncowa" name="Data_koncowa" required>
        </div>
        <div class="form-group">
            <label for="Kategoria_transportu">Kategoria transportu</label>
            <input type="text" class="form-control" id="Kategoria_transportu" name="Kategoria_transportu" required>
        </div>
        <div class="form-group">
            <label for="Cena">Cena</label>
            <input type="number" class="form-control" id="Cena" name="Cena" required>
        </div>
        <button type="submit" name="addTransportPlan" class="btn btn-primary">Dodaj plan transportu</button>
    </form>
</div>

<?php
include_once 'ALLfooter.php'; // Dołączenie stopki strony
?>