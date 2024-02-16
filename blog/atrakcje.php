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
$allowedSortColumns = ['hotelId', 'hotelMiasto', 'hotelNazwa', 'hotelOcena', 'hotelCena'];
if (!in_array($sortColumn, $allowedSortColumns)) {
    $sortColumn = 'hotelId'; // Domyślna kolumna sortowania
}

// Zapytanie SQL z opcjonalnym wyszukiwaniem i sortowaniem
$sql = "SELECT hotelId, hotelMiasto, hotelNazwa, hotelOcena, hotelCena FROM hotele";
if (!empty($searchTerm)) {
    $searchTermEscaped = $conn->real_escape_string($searchTerm);
    $sql .= " WHERE hotelMiasto LIKE '%$searchTermEscaped%' OR hotelNazwa LIKE '%$searchTermEscaped%'";
}
$sql .= " ORDER BY $sortColumn $sortOrder";

$result = $conn->query($sql);

// Początek HTML
echo '<div class="container mt-5">';
    echo '<h1 class="text-center mb-4">Wyszukaj Atrakcje</h1>';

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
  // Uwzględnienie parametru wyszukiwania w linkach sortowania
  echo '<th><a href="?sort=hotelMiasto&order=' . ($sortColumn == 'hotelMiasto' && $sortOrder == 'ASC' ? 'desc' : 'asc') . '&search=' . urlencode($searchTerm) . '">Miasto</a></th>';
  echo '<th><a href="?sort=hotelNazwa&order=' . ($sortColumn == 'hotelNazwa' && $sortOrder == 'ASC' ? 'desc' : 'asc') . '&search=' . urlencode($searchTerm) . '">Nazwa</a></th>';
  echo '<th><a href="?sort=hotelOcena&order=' . ($sortColumn == 'hotelOcena' && $sortOrder == 'ASC' ? 'desc' : 'asc') . '&search=' . urlencode($searchTerm) . '">Ocena</a></th>';
  echo '<th><a href="?sort=hotelCena&order=' . ($sortColumn == 'hotelCena' && $sortOrder == 'ASC' ? 'desc' : 'asc') . '&search=' . urlencode($searchTerm) . '">Cena</a></th>';
  echo '</tr>';
  echo '</thead>';
  echo '<tbody>';
  while($row = $result->fetch_assoc()) {
      echo '<tr>';
      echo '<td>' . htmlspecialchars($row["hotelMiasto"]) . '</td>';
      echo '<td>' . htmlspecialchars($row["hotelNazwa"]) . '</td>';
      echo '<td>' . htmlspecialchars($row["hotelOcena"]) . '</td>';
      echo '<td>' . htmlspecialchars($row["hotelCena"]) . ' zł</td>';
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