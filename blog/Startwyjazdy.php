<?php
include_once 'ALLheader.php'; // Dołączenie nagłówka strony
require_once '../includes/dbh.inc.php'; // Połączenie z bazą danych

// Sprawdzenie zalogowanego użytkownika
if (isset($_SESSION['userid'])) {
    $userId = $_SESSION['userid'];

    // Pobranie wyjazdów powiązanych z użytkownikiem, wraz z nazwą grupy
    $tripsQuery = "SELECT wyjazd.ID_Wyjazdu, wyjazd.Data_Startu, wyjazd.Data_Konca, grupa.Nazwa_Grupy FROM wyjazd
                   JOIN uczestnik_grupy ON wyjazd.ID_Grupy = uczestnik_grupy.ID_Grupy
                   JOIN grupa ON wyjazd.ID_Grupy = grupa.ID_Grupy
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
                    <h5 class="card-title">Wyjazd z grupą: <?= htmlspecialchars($trip['Nazwa_Grupy']) ?></h5>
                    <p>Data rozpoczęcia: <?= htmlspecialchars($trip['Data_Startu']) ?></p>
                    <p>Data zakończenia: <?= htmlspecialchars($trip['Data_Konca']) ?></p>
                    <!-- Tutaj możesz dodać inne informacje dotyczące wyjazdu -->
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Nie znaleziono żadnych wyjazdów dla tego użytkownika.</p>
    <?php endif; ?>
</div>

<?php include_once 'ALLfooter.php'; // Dołączenie stopki strony ?>