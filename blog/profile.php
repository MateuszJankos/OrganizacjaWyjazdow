<?php
include_once 'ALLheader.php';
require_once '../includes/dbh.inc.php';

// Sprawdzenie, czy użytkownik jest zalogowany
if (isset($_SESSION["userid"])) {
    $userid = $_SESSION["userid"];

    // Sprawdzenie czy informacje o profilu już istnieją
    $profilQuery = "SELECT usersName, usersEmail, usersUid, profilOpis FROM users WHERE usersId = ?";
    $profilStmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($profilStmt, $profilQuery)) {
        echo "Błąd zapytania SQL";
        exit();
    }
    mysqli_stmt_bind_param($profilStmt, "i", $userid);
    mysqli_stmt_execute($profilStmt);
    $profilResult = mysqli_stmt_get_result($profilStmt);
    $profil = mysqli_fetch_assoc($profilResult);
    
    // Sprawdzenie czy wynik zapytania nie jest pusty
    if (!$profil) {
        // Możliwe działania w przypadku braku profilu, np. przekierowanie na stronę błędu
        echo "Nie znaleziono profilu.";
        exit();
    }

// Pobranie opisu profilu
$profilOpis = $profil['profilOpis'] ?? "Tu pojawi się twój opis.";

// Pobranie identyfikatorów ulubionych hoteli użytkownika
$ulubioneHoteleQuery = "SELECT hotelId FROM ulubione_hotele WHERE userId = ?";
$ulubioneHoteleStmt = mysqli_stmt_init($conn);
if (!mysqli_stmt_prepare($ulubioneHoteleStmt, $ulubioneHoteleQuery)) {
    echo "Błąd zapytania SQL dla ulubionych hoteli";
    exit();
}
mysqli_stmt_bind_param($ulubioneHoteleStmt, "i", $userid);
mysqli_stmt_execute($ulubioneHoteleStmt);
$ulubioneHoteleResult = mysqli_stmt_get_result($ulubioneHoteleStmt);
$ulubioneHoteleIds = mysqli_fetch_all($ulubioneHoteleResult, MYSQLI_ASSOC);

// Pobranie identyfikatorów ulubionych atrakcji użytkownika
$ulubioneAtrakcjeQuery = "SELECT atraId FROM ulubione_atrakcje WHERE userId = ?";
$ulubioneAtrakcjeStmt = mysqli_stmt_init($conn);
if (!mysqli_stmt_prepare($ulubioneAtrakcjeStmt, $ulubioneAtrakcjeQuery)) {
    echo "Błąd zapytania SQL dla ulubionych atrakcji";
    exit();
}
mysqli_stmt_bind_param($ulubioneAtrakcjeStmt, "i", $userid);
mysqli_stmt_execute($ulubioneAtrakcjeStmt);
$ulubioneAtrakcjeResult = mysqli_stmt_get_result($ulubioneAtrakcjeStmt);
$ulubioneAtrakcjeIds = mysqli_fetch_all($ulubioneAtrakcjeResult, MYSQLI_ASSOC);

?>
<main class="container mt-5">
    <!-- Zawartość profilu -->
    <div class="row">
    <div class="col-md-4">
    <!-- Sekcja informacji o użytkowniku -->
    <img src="profilowe.png" alt="Zdjęcie profilowe" class="img-fluid mb-3">
</div>
<div class="col-md-8">
    <h3>Cześć, jestem <?php echo isset($_SESSION["useruid"]) ? htmlspecialchars($_SESSION["useruid"]) : ''; ?></h3>
    <p>Tutaj można znaleźć więcej informacji o mnie i moich ulubionych miejscach!</p>
    <h4>O MNIE</h4>
    <p><?php echo $profilOpis; ?></p>
    <!-- Przycisk do pokazania formularza -->
    <button id="editDescriptionBtn" class="btn btn-primary">Zaktualizuj opis</button>
    <!-- Formularz do zmiany opisu, domyślnie ukryty -->
    <form action="update_profile_description.php" method="post" id="editDescriptionForm" style="display: none;">
        <div class="form-group">
            <textarea name="profileDescription" class="form-control" rows="4"><?php echo $profilOpis; ?></textarea>
        </div>
        <button type="submit" name="updateDescription" class="btn btn-primary" onclick="toggleEditButton(true)">Zmień opis</button>
    </form>

<script>
    // Skrypt do pokazywania/ukrywania formularza i przycisku edycji
    document.getElementById('editDescriptionBtn').addEventListener('click', function() {
        var form = document.getElementById('editDescriptionForm');
        form.style.display = 'block'; // Pokaż formularz
        this.style.display = 'none'; // Ukryj przycisk
    });

    // Funkcja do przełączania widoczności przycisku edycji
    function toggleEditButton(show) {
        var editBtn = document.getElementById('editDescriptionBtn');
        if (show) {
            editBtn.style.display = 'none';
        } else {
            editBtn.style.display = 'block';
        }
    }
</script>

            <!-- Sekcja ulubionych hoteli -->
            <h4>Ulubiony hotel</h4>
    <ul class="list-group mb-3">
        <?php
        foreach ($ulubioneHoteleIds as $hotelId) {
            if (!empty($hotelId)) {
                // Pobranie informacji o każdym hotelu
                $hotelQuery = "SELECT hotelNazwa, hotelAdres FROM hotele WHERE hotelId = ?";
                $hotelStmt = mysqli_stmt_init($conn);
                if (mysqli_stmt_prepare($hotelStmt, $hotelQuery)) {
                    mysqli_stmt_bind_param($hotelStmt, "i", $hotelId);
                    mysqli_stmt_execute($hotelStmt);
                    $hotelResult = mysqli_stmt_get_result($hotelStmt);
                    $hotel = mysqli_fetch_assoc($hotelResult);
                    
                    echo '<li class="list-group-item">' . htmlspecialchars($hotel['hotelNazwa']) . ' - ' . htmlspecialchars($hotel['hotelAdres']) . '</li>';
                }
            }
        }
        if (empty($profil['profilUluhotel'])) {
            echo '<li class="list-group-item">Brak ulubionych hoteli.</li>';
        }
        ?>
    </ul>

    <h4>Ulubiona atrakcja</h4>
    <ul class="list-group">
        <?php
        foreach ($ulubioneAtrakcjeIds as $atraId) {
            if (!empty($atraId)) {
                // Pobranie informacji o każdej atrakcji
                $atraQuery = "SELECT atraNazwa, atraAdres FROM atrakcje WHERE atraId = ?";
                $atraStmt = mysqli_stmt_init($conn);
                if (mysqli_stmt_prepare($atraStmt, $atraQuery)) {
                    mysqli_stmt_bind_param($atraStmt, "i", $atraId);
                    mysqli_stmt_execute($atraStmt);
                    $atraResult = mysqli_stmt_get_result($atraStmt);
                    $atra = mysqli_fetch_assoc($atraResult);
                    
                    echo '<li class="list-group-item">' . htmlspecialchars($atra['atraNazwa']) . ' - ' . htmlspecialchars($atra['atraAdres']) . '</li>';
                }
            }
        }
        if (empty($profil['profilUluatra'])) {
            echo '<li class="list-group-item">Brak ulubionych atrakcji.</li>';
        }
        ?>
    </ul>
</main>

<?php 
} else {
    echo "Musisz się najpierw zalogować.";
}
include_once 'ALLfooter.php';
?>