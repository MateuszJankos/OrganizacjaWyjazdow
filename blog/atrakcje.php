<?php 
  include_once 'ALLheader.php';
?>

<main class="container">

<?php
require_once '../includes/dbh.inc.php';

// Pobranie parametrów wyszukiwania i sortowania
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
$sortColumn = isset($_GET['sort']) ? $_GET['sort'] : 'atraId';
$sortOrder = isset($_GET['order']) && $_GET['order'] === 'desc' ? 'DESC' : 'ASC';

// Bezpieczne sortowanie
$allowedSortColumns = ['atraId', 'RodzajAtrakcji', 'atraNazwa', 'atraAdres', 'atraOcena'];
if (!in_array($sortColumn, $allowedSortColumns)) {
    $sortColumn = 'atraId'; // Domyślna kolumna sortowania
}

// Zapytanie SQL z opcjonalnym wyszukiwaniem i sortowaniem dla atrakcji
$sql = "SELECT atraId, RodzajAtrakcji, atraNazwa, atraAdres, atraOcena FROM Atrakcje";
if (!empty($searchTerm)) {
    $searchTermEscaped = $conn->real_escape_string($searchTerm);
    $sql .= " WHERE RodzajAtrakcji LIKE '%$searchTermEscaped%' OR atraNazwa LIKE '%$searchTermEscaped%' OR atraAdres LIKE '%$searchTermEscaped%'";
}
$sql .= " ORDER BY $sortColumn $sortOrder";

$result = $conn->query($sql);

// Początek HTML
echo '<div class="container mt-5">';
    echo '<h1 class="text-center mb-4">Wyszukaj Atrakcje</h1>';

    echo '<div class="row justify-content-center">';
        echo '<div class="col-md-6">';
            echo '<form action="" method="get">';
            echo '<div class="input-group mb-3">';
                echo '<input type="text" name="search" class="form-control" placeholder="Dostępne miasta: Gdańsk, Kraków, Wrocław lub wyszukaj nazwy, opisy">';
                echo '<button class="btn btn-primary" type="submit">Szukaj</button>';
            echo '</div>';
            echo '</form>';
        echo '</div>';
    echo '</div>';
echo '</div>';

// Sprawdzenie wyników i wyświetlenie tabeli
// Sprawdzenie wyników i wyświetlenie tabeli
if ($result && $result->num_rows > 0) {
    echo '<table class="table table-striped table-hover">';
    echo '<thead class="thead-dark">';
    echo '<tr>';
    // Nagłówki tabeli z linkami do sortowania
    echo '<th><a href="?sort=RodzajAtrakcji&order=' . ($sortColumn == 'RodzajAtrakcji' && $sortOrder == 'ASC' ? 'desc' : 'asc') . '&search=' . urlencode($searchTerm) . '">Miasto</a></th>';
    echo '<th><a href="?sort=atraNazwa&order=' . ($sortColumn == 'atraNazwa' && $sortOrder == 'ASC' ? 'desc' : 'asc') . '&search=' . urlencode($searchTerm) . '">Nazwa</a></th>';
    echo '<th><a href="?sort=atraAdres&order=' . ($sortColumn == 'atraAdres' && $sortOrder == 'ASC' ? 'desc' : 'asc') . '&search=' . urlencode($searchTerm) . '">Ocena</a></th>';
    echo '<th><a href="?sort=atraOcena&order=' . ($sortColumn == 'atraOcena' && $sortOrder == 'ASC' ? 'desc' : 'asc') . '&search=' . urlencode($searchTerm) . '">Ocena</a></th>';
    echo '<th>Działanie</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    while($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($row["RodzajAtrakcji"]) . '</td>';
        echo '<td>' . htmlspecialchars($row["atraNazwa"]) . '</td>';
        echo '<td>' . htmlspecialchars($row["atraAdres"]) . '</td>';
        echo '<td>' . htmlspecialchars($row["atraOcena"]) . '</td>';
        // Dodanie przycisków "Dodaj do ulubionych" lub "Usuń z ulubionych"
        echo '<td>';
        if (isset($_SESSION["userid"])) {
            $userId = $_SESSION["userid"];
            // Sprawdź, czy atrakcja jest już dodana do ulubionych
            $profilQuery = "SELECT profilUluatra FROM profil WHERE usersId = ?";
            $profilStmt = mysqli_stmt_init($conn);
            if (mysqli_stmt_prepare($profilStmt, $profilQuery)) {
                mysqli_stmt_bind_param($profilStmt, "i", $userId);
                mysqli_stmt_execute($profilStmt);
                $resultProfil = mysqli_stmt_get_result($profilStmt);
                if ($profil = mysqli_fetch_assoc($resultProfil)) {
                    $currentFavorites = $profil['profilUluatra'] ? explode(',', $profil['profilUluatra']) : [];
                    if (!in_array($row["atraId"], $currentFavorites)) {
                        // Jeśli atrakcja nie jest jeszcze w ulubionych, dodaj przycisk umożliwiający dodanie
                        echo '<form action="add_to_favorites_atrakcje.php" method="post">';
                        echo '<input type="hidden" name="atraId" value="' . $row["atraId"] . '">';
                        echo '<button type="submit" name="addFavoriteAtrakcja" class="btn btn-primary btn-sm">Dodaj do ulubionych</button>';
                        echo '</form>';
                    } else {
                        // Jeśli atrakcja jest już w ulubionych, dodaj przycisk umożliwiający usunięcie
                        echo '<form action="remove_from_favorites_atrakcje.php" method="post">';
                        echo '<input type="hidden" name="atraId" value="' . $row["atraId"] . '">';
                        echo '<button type="submit" name="removeFavoriteAtrakcja" class="btn btn-danger btn-sm">Usuń z ulubionych</button>';
                        echo '</form>';
                    }
                } else {
                    echo 'Błąd podczas pobierania informacji o ulubionych atrakcjach.';
                }
            } else {
                echo 'Błąd zapytania SQL.';
            }
        } else {
            echo 'Zaloguj się, aby dodać do ulubionych.';
        }
        echo '</td>';
        echo '</tr>';
    }
echo '</tbody>';
echo '</table>';
} else {
echo "Nie znaleziono atrakcji.";
}
?>


  <div class="row mb-2">
    <div class="col-md-6">
      <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
        <div class="col p-4 d-flex flex-column position-static">
          <strong class="d-inline-block mb-2 text-primary-emphasis">Świat</strong>
          <h3 class="mb-0">Witaj Hiszpanio!</h3>
          <div class="mb-1 text-body-secondary">Najnowsza oferta!</div>
          <p class="card-text mb-auto">Odkryj magię Hiszpanii, gdzie słoneczne plaże, bogata historia i wyśmienita kuchnia tworzą niezapomniane doświadczenie podróży.</p>
          <a href="#" class="icon-link gap-1 icon-link-hover stretched-link">
            Zaplanuj wyjazd
            <svg class="bi"><use xlink:href="#chevron-right"/></svg>
          </a>
        </div>
        <div class="col-auto d-none d-lg-block">
            <img src="hiszpania.jpg" alt="Thumbnail" width="200" height="250">
        </div>
    </div>
</div>
    <div class="col-md-6">
      <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
          <div class="col p-4 d-flex flex-column position-static">
              <strong class="d-inline-block mb-2 text-success-emphasis">Polska</strong>
              <h3 class="mb-0">Polska zatoka</h3>
              <div class="mb-1 text-body-secondary">Oferta na weekend</div>
              <p class="mb-auto">Odkryj urok polskiego Helu z jego pięknymi plażami, klifami i wyjątkowym nadmorskim klimatem.</p>
              <a href="#" class="icon-link gap-1 icon-link-hover stretched-link">
                  Zaplanuj wyjazd
                  <svg class="bi"><use xlink:href="#chevron-right"/></svg>
              </a>
          </div>
          <div class="col-auto d-none d-lg-block">
              <img src="hel.jpg" alt="Thumbnail" width="200" height="250">
          </div>
      </div>
  </div>
  
</main>

<?php 
  include_once 'ALLfooter.php';
?>