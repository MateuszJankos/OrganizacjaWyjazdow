<?php
include_once 'ALLheader.php'; // Dołączenie nagłówka strony
require_once '../includes/dbh.inc.php'; // Połączenie z bazą danych

$transportSelected = isset($_POST['transportType']);
$tripPlanned = false;

$tripSelected = isset($_POST['trip']) && $_POST['trip'] === "Wyjazd 01.03.2024";

// Logika planowania transportu na podstawie wysłanego formularza
if ($tripSelected && $transportSelected && isset($_POST['startPoint'], $_POST['endPoint'])) {
    $tripPlanned = true;
    $transportType = htmlspecialchars($_POST['transportType']);
    $startPoint = htmlspecialchars($_POST['startPoint']);
    $endPoint = htmlspecialchars($_POST['endPoint']);
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
        <h3>Zaplanuj transport</h3>
        <form action="" method="post">
            <input type="hidden" name="trip" value="Wyjazd 01.03.2024">
            <div class="form-group">
                <label for="transportType">Rodzaj transportu</label>
                <select class="form-select" id="transportType" name="transportType">
                    <option value="Autobus">Autobus</option>
                    <option value="Pociąg">Pociąg</option>
                    <option value="Samochód">Samochód</option>
                    <option value="Rower">Rower</option>
                </select>
            </div>
            <div class="form-group">
                <label for="startPoint">Miejsce początkowe</label>
                <input type="text" class="form-control" id="startPoint" name="startPoint" value="Hotel Leśna - Rzeczna 84" required>
            </div>
            <div class="form-group">
                <label for="endPoint">Miejsce końcowe</label>
                <input type="text" class="form-control" id="endPoint" name="endPoint" value="Katedra Wawelska - Malinowa 91" required>
            </div>
            <button type="submit" name="planTransport" class="btn btn-success mt-3">Zaplanuj transport</button>
        </form>
    <?php endif; ?>

    <?php if ($tripPlanned): ?>
        <div class="alert alert-success mt-3" role="alert">
            Transport <?= $transportType ?> został zaplanowany z <?= $startPoint ?> do <?= $endPoint ?>.
        </div>
    <?php endif; ?>
</div>

<?php
include_once 'ALLfooter.php'; // Dołączenie stopki strony
?>