<?php
include_once 'ALLheader.php'; // Dołączenie nagłówka strony
require_once '../includes/dbh.inc.php'; // Połączenie z bazą danych

$tripSelected = isset($_POST['trip']) && $_POST['trip'] === "Wyjazd 01.03.2024";
$reservationCreated = false;

// Simulate reservation creation logic based on form submission
if ($tripSelected && isset($_POST['hotelName'], $_POST['checkInDate'], $_POST['checkOutDate'], $_POST['guests'])) {
    $reservationCreated = true;
    $hotelName = htmlspecialchars($_POST['hotelName']);
    $checkInDate = htmlspecialchars($_POST['checkInDate']);
    $checkOutDate = htmlspecialchars($_POST['checkOutDate']);
    $guests = intval($_POST['guests']);
}
?>

<div class="container mt-5">
    <h2>Dodaj rezerwację hotelową do wyjazdu</h2>
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
        <h3>Dodaj rezerwację hotelową</h3>
        <form action="" method="post">
            <input type="hidden" name="trip" value="Wyjazd 01.03.2024">
            <div class="form-group">
                <label for="hotelName">Nazwa hotelu</label>
                <input type="text" class="form-control" id="hotelName" name="hotelName" required>
            </div>
            <div class="form-group">
                <label for="checkInDate">Data zameldowania</label>
                <input type="date" class="form-control" id="checkInDate" name="checkInDate" required>
            </div>
            <div class="form-group">
                <label for="checkOutDate">Data wymeldowania</label>
                <input type="date" class="form-control" id="checkOutDate" name="checkOutDate" required>
            </div>
            <div class="form-group">
                <label for="guests">Liczba gości</label>
                <input type="number" class="form-control" id="guests" name="guests" required min="1">
            </div>
            <button type="submit" name="createReservation" class="btn btn-success mt-3">Dodaj rezerwację</button>
        </form>
    <?php endif; ?>

    <?php if ($reservationCreated): ?>
        <div class="alert alert-success mt-3" role="alert">
            Rezerwacja hotelu <?= $hotelName ?> została dodana! (Zameldowanie: <?= $checkInDate ?>, Wymeldowanie: <?= $checkOutDate ?>, Gości: <?= $guests ?>)
        </div>
    <?php endif; ?>
</div>

<?php
include_once 'ALLfooter.php'; // Dołączenie stopki strony
?>