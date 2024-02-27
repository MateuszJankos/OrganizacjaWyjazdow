<?php
include_once 'ALLheader.php'; // Dołączenie nagłówka strony
require_once '../includes/dbh.inc.php'; // Połączenie z bazą danych

// Sprawdzenie zalogowanego użytkownika
if (isset($_SESSION['userid'])) {
    $userId = $_SESSION['userid'];

    // Pobranie dostępnych hoteli
    $hotelsQuery = "SELECT hotelId, hotelNazwa FROM hotele";
    $hotelsResult = $conn->query($hotelsQuery);
    $hotels = $hotelsResult->fetch_all(MYSQLI_ASSOC);

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
    <h2>Dodaj rezerwację hotelu</h2>
    <form action="addReservation.php" method="post">
        <div class="form-group">
            <label for="hotelId">Hotel</label>
            <select class="form-control" id="hotelId" name="hotelId" required>
                <?php foreach ($hotels as $hotel): ?>
                    <option value="<?= htmlspecialchars($hotel['hotelId']) ?>"><?= htmlspecialchars($hotel['hotelNazwa']) ?></option>
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
            <label for="Data_Start_rezerwacji">Data startu rezerwacji</label>
            <input type="date" class="form-control" id="Data_Start_rezerwacji" name="Data_Start_rezerwacji" required>
        </div>
        <div class="form-group">
            <label for="Data_koniec_rezerwacji">Data końca rezerwacji</label>
            <input type="date" class="form-control" id="Data_koniec_rezerwacji" name="Data_koniec_rezerwacji" required>
        </div>
        <div class="form-group">
            <label for="Opis_pokoju">Opis pokoju</label>
            <textarea class="form-control" id="Opis_pokoju" name="Opis_pokoju" required></textarea>
        </div>
        <button type="submit" name="addReservation" class="btn btn-primary">Dodaj rezerwację</button>
    </form>
</div>

<?php
include_once 'ALLfooter.php'; // Dołączenie stopki strony
?>