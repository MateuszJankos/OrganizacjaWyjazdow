<?php
include_once 'ALLheader.php'; // Dołączenie nagłówka strony
require_once '../includes/dbh.inc.php'; // Połączenie z bazą danych

$groupSelected = isset($_POST['groupName']) && $_POST['groupName'] === "Narty";
$tripCreated = false;

if ($groupSelected && isset($_POST['destination'], $_POST['startDate'], $_POST['endDate'])) {
    // Simulate creating a trip
    $tripCreated = true;
    $destination = $_POST['destination'];
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];
}
?>

<div class="container mt-5">
    <h2>Wybierz grupę</h2>
    <form action="" method="post">
        <div class="form-group">
            <label for="groupName">Grupa</label>
            <select class="form-control" id="groupName" name="groupName">
                <option value="Narty">Narty - Wyjazdy w góry na ferie</option>
            </select>
        </div>
        <button type="submit" name="selectGroup" class="btn btn-primary mt-3">Wybierz grupę</button>
    </form>

    <?php if ($groupSelected): ?>
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