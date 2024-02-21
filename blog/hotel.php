<?php 
  include_once 'ALLheader.php';
?>

<main class="container">

<?php
require_once '../includes/dbh.inc.php';

// Pobranie parametrów wyszukiwania i sortowania
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
$sortColumn = isset($_GET['sort']) ? $_GET['sort'] : 'hotelId';
$sortOrder = isset($_GET['order']) && $_GET['order'] === 'desc' ? 'DESC' : 'ASC';

// Bezpieczne sortowanie
$allowedSortColumns = ['hotelId', 'hotelNazwa', 'hotelOcena', 'hotelCena', 'hotelAdres', 'NazwaMiasta'];
if (!in_array($sortColumn, $allowedSortColumns)) {
    $sortColumn = 'hotelId'; // Domyślna kolumna sortowania
}

// Zapytanie SQL z opcjonalnym wyszukiwaniem i sortowaniem
$sql = "SELECT hotele.hotelId, hotele.hotelNazwa, hotele.hotelOcena, hotele.hotelCena, hotele.hotelAdres, Miasta.NazwaMiasta 
        FROM hotele
        INNER JOIN Miasta ON hotele.ID_miasta = Miasta.ID_miasta";
if (!empty($searchTerm)) {
    $searchTermEscaped = $conn->real_escape_string($searchTerm);
    $sql .= " WHERE Miasta.NazwaMiasta LIKE '%$searchTermEscaped%' 
              OR hotele.hotelNazwa LIKE '%$searchTermEscaped%'
              OR hotele.hotelAdres LIKE '%$searchTermEscaped%'";
}
$sql .= " ORDER BY $sortColumn $sortOrder";

$result = $conn->query($sql);

// Początek HTML
echo '<div class="container mt-5">';
    echo '<h1 class="text-center mb-4">Wyszukaj Hotel</h1>';

    echo '<div class="row justify-content-center">';
        echo '<div class="col-md-6">';
            echo '<form action="" method="get">'; // Dodany tag formularza
            echo '<div class="input-group mb-3">';
                echo '<input type="text" name="search" class="form-control" placeholder="Dostępne miasta: Gdańsk, Kraków, Wrocław lub wyszukaj nazwy">';
                echo '<button class="btn btn-primary" type="submit">Szukaj</button>';
            echo '</div>';
            echo '</form>'; // Zamknięcie tagu formularza
        echo '</div>';
    echo '</div>';
echo '</div>';

// Sprawdzenie wyników i wyświetlenie tabeli
if ($result && $result->num_rows > 0) {
  echo '<table class="table table-striped table-hover">';
  echo '<thead class="thead-dark">';
  echo '<tr>';
  // Linki sortowania z uwzględnieniem parametru wyszukiwania
  echo '<th><a href="?sort=NazwaMiasta&order=' . ($sortColumn == 'NazwaMiasta' && $sortOrder == 'ASC' ? 'desc' : 'asc') . '&search=' . urlencode($searchTerm) . '">Miasto</a></th>';
  echo '<th><a href="?sort=hotelNazwa&order=' . ($sortColumn == 'hotelNazwa' && $sortOrder == 'ASC' ? 'desc' : 'asc') . '&search=' . urlencode($searchTerm) . '">Nazwa</a></th>';
  echo '<th><a href="?sort=hotelOcena&order=' . ($sortColumn == 'hotelOcena' && $sortOrder == 'ASC' ? 'desc' : 'asc') . '&search=' . urlencode($searchTerm) . '">Ocena</a></th>';
  echo '<th><a href="?sort=hotelCena&order=' . ($sortColumn == 'hotelCena' && $sortOrder == 'ASC' ? 'desc' : 'asc') . '&search=' . urlencode($searchTerm) . '">Cena</a></th>';
  echo '<th><a href="?sort=hotelAdres&order=' . ($sortColumn == 'hotelAdres' && $sortOrder == 'ASC' ? 'desc' : 'asc') . '&search=' . urlencode($searchTerm) . '">Adres</a></th>';
  echo '<th>Działanie</th>';
  echo '</tr>';
  echo '</thead>';
  echo '<tbody>';
  while($row = $result->fetch_assoc()) {
    echo '<tr>';
    echo '<td>' . htmlspecialchars($row["NazwaMiasta"]) . '</td>';
    echo '<td>' . htmlspecialchars($row["hotelNazwa"]) . '</td>';
    echo '<td>' . htmlspecialchars($row["hotelOcena"]) . ' / 5.00</td>';
    echo '<td>' . htmlspecialchars($row["hotelCena"]) . ' zł</td>';
    echo '<td>' . htmlspecialchars($row["hotelAdres"]) . '</td>';
    // Przycisk "Dodaj do ulubionych"
    echo '<td>';
    if (isset($_SESSION["userid"])) {
    $userId = $_SESSION["userid"];
    // Sprawdź, czy hotel jest już dodany do ulubionych
    $profilQuery = "SELECT profilUluhotel FROM profil WHERE usersId = ?";
    $profilStmt = mysqli_stmt_init($conn);
    if (mysqli_stmt_prepare($profilStmt, $profilQuery)) {
        mysqli_stmt_bind_param($profilStmt, "i", $userId);
        mysqli_stmt_execute($profilStmt);
        $resultProfil = mysqli_stmt_get_result($profilStmt);
        $profil = mysqli_fetch_assoc($resultProfil);
        $currentFavorites = $profil['profilUluhotel'] ? explode(',', $profil['profilUluhotel']) : [];
        
        if (!in_array($row["hotelId"], $currentFavorites)) {
            // Jeśli hotel nie jest jeszcze w ulubionych, dodaj przycisk umożliwiający dodanie
            echo '<form action="add_to_favorites.php" method="post">';
            echo '<input type="hidden" name="hotelId" value="' . $row["hotelId"] . '">';
            echo '<button type="submit" name="addFavorite" class="btn btn-primary btn-sm">Dodaj do ulubionych</button>';
            echo '</form>';
        } else {
            // Jeśli hotel jest już w ulubionych, dodaj przycisk umożliwiający usunięcie
            echo '<form action="remove_from_favorites.php" method="post" style="display: inline-block;">';
            echo '<input type="hidden" name="hotelId" value="' . $row["hotelId"] . '">';
            echo '<button type="submit" name="removeFavorite" class="btn btn-danger btn-sm">Usuń z ulubionych</button>';
            echo '</form>';
        }
    }
}
 else {
        echo 'Zaloguj się, aby dodać do ulubionych.';
    }
    echo '</td>';
    echo '</tr>';
  }
  echo '</tbody>';
  echo '</table>';
} else {
  echo "Nie znaleziono hoteli.";
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