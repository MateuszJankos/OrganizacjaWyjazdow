<?php
include_once 'ALLheader.php'; // Dołączenie nagłówka strony
require_once '../includes/dbh.inc.php'; // Połączenie z bazą danych

// Sprawdzenie zalogowanego użytkownika
if (isset($_SESSION['userid'])) {
    $userId = $_SESSION['userid'];

    // Pobranie wyjazdów powiązanych z użytkownikiem, wraz z nazwą grupy i informacjami o rezerwacji hotelu
    $tripsQuery = "SELECT wyjazd.ID_Wyjazdu, wyjazd.Data_Startu, wyjazd.Data_Konca, grupa.Nazwa_Grupy, 
                          hotele.hotelNazwa AS Hotele, rezerwacja_hotelu.Data_start_rezerwacji, rezerwacja_hotelu.Data_koniec_rezerwacji
                   FROM wyjazd
                   JOIN grupa ON wyjazd.ID_Grupy = grupa.ID_Grupy
                   JOIN uczestnik_grupy ON wyjazd.ID_Grupy = uczestnik_grupy.ID_Grupy
                   LEFT JOIN rezerwacja_hotelu ON wyjazd.ID_Wyjazdu = rezerwacja_hotelu.ID_Wyjazdu
                   LEFT JOIN hotele ON rezerwacja_hotelu.hotelId = hotele.hotelId
                   WHERE uczestnik_grupy.usersId = ?";
    $stmt = $conn->prepare($tripsQuery);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $tripsResult = $stmt->get_result();
    $trips = $tripsResult->fetch_all(MYSQLI_ASSOC);
}
?>

<div class="container mt-5">
    <h2>Twoje wyjazdy</h2>
    <?php if (!empty($trips)): ?>
        <?php foreach ($trips as $trip): ?>
            <div class="card mt-3">
                <div class="card-body">
                    <h5 class="card-title">Wyjazd (Grupa: <?= htmlspecialchars($trip['Nazwa_Grupy']) ?>)</h5>
                    <p>Data rozpoczęcia: <?= htmlspecialchars($trip['Data_Startu']) ?></p>
                    <p>Data zakończenia: <?= htmlspecialchars($trip['Data_Konca']) ?></p>
                    <?php if (!empty($trip['Hotele'])): ?>
                        <p>Hotel: <?= htmlspecialchars($trip['Hotele']) ?></p>
                        <p>Data przyjazdu do hotelu: <?= htmlspecialchars($trip['Data_start_rezerwacji']) ?></p>
                        <p>Data wyjazdu z hotelu: <?= htmlspecialchars($trip['Data_koniec_rezerwacji']) ?></p>
                    <?php else: ?>
                        <p>Brak rezerwacji hotelu dla tego wyjazdu.</p>
                    <?php endif; ?>
                    <!-- Tutaj możesz dodać inne informacje dotyczące wyjazdu -->
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Nie znaleziono żadnych wyjazdów dla tego użytkownika.</p>
    <?php endif; ?>
</div>

<?php include_once 'ALLfooter.php'; // Dołączenie stopki strony ?>