<?php 
  include_once 'ALLheader.php';
?>

<?php
require_once '../includes/dbh.inc.php'; // Załóżmy, że plik 'dbh.inc.php' zawiera połączenie z bazą danych

// Sprawdzenie, czy użytkownik jest zalogowany
if (isset($_SESSION["userid"])) {
    $userid = $_SESSION["userid"];
    
    // Pobranie danych profilu użytkownika
    $sql = "SELECT * FROM profil WHERE usersId = ?";
    $stmt = mysqli_stmt_init($conn);
    
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo "Błąd zapytania SQL";
    } else {
        mysqli_stmt_bind_param($stmt, "i", $userid);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if ($row = mysqli_fetch_assoc($result)) {
            // Profil istnieje, wyświetlamy dane
            $profilOpis = $row['profilOpis'];
            $profilUluhotel = $row['profilUluhotel'];
            $profilUluatra = $row['profilUluatra'];
            // Tutaj dodaj kod do wyświetlania danych
        } else {
            // Profil nie istnieje, tworzymy nowy
            $sqlInsert = "INSERT INTO profil (usersId, usersUid) VALUES (?, ?)";
            $stmtInsert = mysqli_stmt_init($conn);
            
            if (!mysqli_stmt_prepare($stmtInsert, $sqlInsert)) {
                echo "Błąd zapytania SQL";
            } else {
                $usersUid = $_SESSION["useruid"]; // Zakładamy, że 'useruid' to nazwa użytkownika
                mysqli_stmt_bind_param($stmtInsert, "is", $userid, $usersUid);
                mysqli_stmt_execute($stmtInsert);
                
                // Teraz można pobrać dane nowego profilu, jeśli jest taka potrzeba
            }
        }
    }
} else {
    echo "Musisz się najpierw zalogować.";
}
?>

<main class="container mt-5">
    <div class="row">
        <div class="col-md-4">
            <img src="profilowe.png" alt="Zdjęcie profilowe" class="img-fluid mb-3">
            <h3>O MNIE</h3>
            <p>Opisa osoby która posiada ten profil. Tutaj możesz dodać więcej szczegółów o sobie, swoich zainteresowaniach czy doświadczeniu.</p>
        </div>
        <div class="col-md-8">
            <h3>Cześć, jestem 
                <?php 
                if (isset($_SESSION["useruid"])) {
                    echo $_SESSION["useruid"];
                }
                ?>
            </h3>
            <p>Kolejny opis mówiący o ulubionych wycieczkach osoby. Możesz tutaj wymienić miejsca, które odwiedziłeś/aś i dlaczego są one dla Ciebie ważne.</p>
            
            <h4>Ulubione wycieczki</h4>
            <ul class="list-group mb-3">
                <li class="list-group-item">Wycieczka 1 - krótki opis</li>
                <li class="list-group-item">Wycieczka 2 - krótki opis</li>
                <li class="list-group-item">Wycieczka 3 - krótki opis</li>
            </ul>

            <h4>Ulubione hotele</h4>
            <ul class="list-group mb-3">
                <li class="list-group-item">Hotel 1 - lokalizacja, krótki opis</li>
                <li class="list-group-item">Hotel 2 - lokalizacja, krótki opis</li>
                <li class="list-group-item">Hotel 3 - lokalizacja, krótki opis</li>
            </ul>

            <h4>Ulubione atrakcje</h4>
            <ul class="list-group">
                <li class="list-group-item">Atrakcja 1 - lokalizacja, krótki opis</li>
                <li class="list-group-item">Atrakcja 2 - lokalizacja, krótki opis</li>
                <li class="list-group-item">Atrakcja 3 - lokalizacja, krótki opis</li>
            </ul>
        </div>
    </div>
</main>

<?php 
  include_once 'ALLfooter.php';
?>