<?php
include_once 'ALLheader.php'; // Dołączenie nagłówka strony
require_once '../includes/dbh.inc.php'; // Połączenie z bazą danych

$attractionSelected = isset($_POST['attractionName']);
$visitPlanned = false;

$tripSelected = isset($_POST['trip']) && $_POST['trip'] === "Wyjazd 01.03.2024";
$attractionSelected = isset($_POST['attractionName']);
$visitPlanned = false;

// Simulate planning a visit logic based on form submission
if ($tripSelected && $attractionSelected && isset($_POST['visitDate'], $_POST['visitTime'])) {
    $visitPlanned = true;
    $attractionName = htmlspecialchars($_POST['attractionName']);
    $visitDate = htmlspecialchars($_POST['visitDate']);
    $visitTime = htmlspecialchars($_POST['visitTime']);
}
?>

<div class="container mt-5">
    <h2>Wybierz wyjazd</h2>
    <form action="" method="post">
        <div class="form-group">
            <label for="trip">Wyjazd</label>
            <select class="form-select" id="trip" name="trip">
                <option value="Wyjazd 01.03.2024">Wyjazd 01.03.2024</option>
            </select>
        </div>
        <button type="submit" name="selectTrip" class="btn btn-primary mt-3">Wybierz wyjazd</button>
    </form>

    <?php if ($tripSelected): ?>
        <h3>Zaplanuj wizytę w atrakcji</h3>
        <form action="" method="post">
            <input type="hidden" name="trip" value="Wyjazd 01.03.2024">
            <div class="form-group">
                <label for="attractionName">Atrakcja</label>
                <select class="form-select" id="attractionName" name="attractionName">
                    <option value="Muzeum Narodowe">Muzeum Narodowe</option>
                    <option value="Zamek Królewski">Zamek Królewski</option>
                    <option value="Park Rozrywki">Park Rozrywki</option>
                </select>
            </div>
            <div class="form-group">
                <label for="visitDate">Data wizyty</label>
                <input type="date" class="form-control" id="visitDate" name="visitDate" required>
            </div>
            <div class="form-group">
                <label for="visitTime">Godzina wizyty</label>
                <input type="time" class="form-control" id="visitTime" name="visitTime" required>
            </div>
            <button type="submit" name="planVisit" class="btn btn-success mt-3">Zaplanuj wizytę</button>
        </form>
    <?php endif; ?>

    <?php if ($visitPlanned): ?>
        <div class="alert alert-success mt-3" role="alert">
            Wizyta w atrakcji <?= $attractionName ?> została zaplanowana na <?= $visitDate ?> o godzinie <?= $visitTime ?>.
        </div>
    <?php endif; ?>
</div>

<?php
include_once 'ALLfooter.php'; // Dołączenie stopki strony
?>