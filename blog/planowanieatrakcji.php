<?php
include_once 'ALLheader.php'; // Include page header
require_once '../includes/dbh.inc.php'; // Include database connection

// Check if user is logged in
if (isset($_SESSION['userid'])) {
    $userId = $_SESSION['userid'];

    // Retrieve available attractions
    $attractionsQuery = "SELECT atraId, atraNazwa FROM atrakcje";
    $attractionsResult = $conn->query($attractionsQuery);
    $attractions = $attractionsResult->fetch_all(MYSQLI_ASSOC);

    // Retrieve trips associated with groups the user belongs to
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
    <h2>Planowanie atrakcji</h2>
    <form action="addAttractionPlan.php" method="post">
        <div class="form-group">
            <label for="atraId">Atrakcja</label>
            <select class="form-control" id="atraId" name="atraId" required>
                <?php foreach ($attractions as $attraction): ?>
                    <option value="<?= htmlspecialchars($attraction['atraId']) ?>"><?= htmlspecialchars($attraction['atraNazwa']) ?></option>
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
            <label for="Data_wizyty">Data wizyty</label>
            <input type="date" class="form-control" id="Data_wizyty" name="Data_wizyty" required>
        </div>
        <button type="submit" name="addAttractionPlan" class="btn btn-primary">Dodaj plan</button>
    </form>
</div>

<?php
include_once 'ALLfooter.php'; // Include page footer
?>