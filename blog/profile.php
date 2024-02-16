<?php 
include_once 'ALLheader.php';
require_once '../includes/dbh.inc.php';

// Sprawdzenie, czy użytkownik jest zalogowany
if (isset($_SESSION["userid"])) {
    $userid = $_SESSION["userid"];

    // Sprawdzenie czy profil już istnieje
    $profilQuery = "SELECT * FROM profil WHERE usersId = ?";
    $profilStmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($profilStmt, $profilQuery)) {
        echo "Błąd zapytania SQL";
        exit();
    }
    mysqli_stmt_bind_param($profilStmt, "i", $userid);
    mysqli_stmt_execute($profilStmt);
    $profilResult = mysqli_stmt_get_result($profilStmt);
    $profil = mysqli_fetch_assoc($profilResult);
    
    // Jeśli profil nie istnieje, utwórz nowy
    if (!$profil) {
        $insertProfilQuery = "INSERT INTO profil (usersId) VALUES (?)";
        $insertProfilStmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($insertProfilStmt, $insertProfilQuery)) {
            echo "Błąd przy tworzeniu nowego profilu";
            exit();
        }
        mysqli_stmt_bind_param($insertProfilStmt, "i", $userid);
        mysqli_stmt_execute($insertProfilStmt);
        
        // Pobierz nowo utworzony profil
        mysqli_stmt_execute($profilStmt);
        $profilResult = mysqli_stmt_get_result($profilStmt);
        $profil = mysqli_fetch_assoc($profilResult);
    }
    
    // Pobranie ulubionych hoteli i atrakcji
    $ulubioneHoteleIds = explode(',', $profil['profilUluhotel']);
    $ulubioneAtrakcjeIds = explode(',', $profil['profilUluatra']);
?>

<main class="container mt-5">
    <!-- Zawartość profilu -->
    <div class="row">
        <div class="col-md-4">
            <!-- Sekcja informacji o użytkowniku -->
            <img src="profilowe.png" alt="Zdjęcie profilowe" class="img-fluid mb-3">
            <h3>O MNIE</h3>
            <p><?php if (isset($profilOpis)) { echo htmlspecialchars($profilOpis); } else { echo "Tu pojawi się twój opis."; } ?></p>
        </div>
        <div class="col-md-8">
            <h3>Cześć, jestem <?php if (isset($_SESSION["useruid"])) { echo htmlspecialchars($_SESSION["useruid"]); } ?></h3>
            <p>Tutaj możesz dodać więcej informacji o swoich ulubionych miejscach i wycieczkach.</p>

            <!-- Sekcja ulubionych hoteli -->
            <h4>Ulubione hotele</h4>
    <ul class="list-group mb-3">
        <?php
        foreach ($ulubioneHoteleIds as $hotelId) {
            if (!empty($hotelId)) {
                // Pobranie informacji o każdym hotelu
                $hotelQuery = "SELECT hotelNazwa, hotelMiasto FROM hotele WHERE hotelId = ?";
                $hotelStmt = mysqli_stmt_init($conn);
                if (mysqli_stmt_prepare($hotelStmt, $hotelQuery)) {
                    mysqli_stmt_bind_param($hotelStmt, "i", $hotelId);
                    mysqli_stmt_execute($hotelStmt);
                    $hotelResult = mysqli_stmt_get_result($hotelStmt);
                    $hotel = mysqli_fetch_assoc($hotelResult);
                    
                    echo '<li class="list-group-item">' . htmlspecialchars($hotel['hotelNazwa']) . ' - ' . htmlspecialchars($hotel['hotelMiasto']) . '</li>';
                }
            }
        }
        if (empty($profil['profilUluhotel'])) {
            echo '<li class="list-group-item">Brak ulubionych hoteli.</li>';
        }
        ?>
    </ul>

    <h4>Ulubione atrakcje</h4>
    <ul class="list-group">
        <?php
        foreach ($ulubioneAtrakcjeIds as $atraId) {
            if (!empty($atraId)) {
                // Pobranie informacji o każdej atrakcji
                $atraQuery = "SELECT atraNazwa, atraMiasto FROM atrakcje WHERE atraId = ?";
                $atraStmt = mysqli_stmt_init($conn);
                if (mysqli_stmt_prepare($atraStmt, $atraQuery)) {
                    mysqli_stmt_bind_param($atraStmt, "i", $atraId);
                    mysqli_stmt_execute($atraStmt);
                    $atraResult = mysqli_stmt_get_result($atraStmt);
                    $atra = mysqli_fetch_assoc($atraResult);
                    
                    echo '<li class="list-group-item">' . htmlspecialchars($atra['atraNazwa']) . ' - ' . htmlspecialchars($atra['atraMiasto']) . '</li>';
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