<?php 
  include_once 'ALLheader.php';
?>

<main class="container">

<?php
require_once '../includes/dbh.inc.php';

// Sprawdzenie, czy formularz wyszukiwania został wysłany
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

// Zapytanie SQL do pobrania informacji o hotelach
$sql = "SELECT hotelId, hotelMiasto, hotelNazwa, hotelOcena, hotelCena FROM hotele";
if ($searchTerm) {
    $sql .= " WHERE hotelMiasto LIKE '%$searchTerm%' OR hotelNazwa LIKE '%$searchTerm%'";
}

$result = $conn->query($sql);

// Początek HTML
echo '<div class="container mt-5">';
    echo '<h1 class="text-center mb-4">Wyszukaj Hotele</h1>';

    echo '<div class="row justify-content-center">';
        echo '<div class="col-md-6">';
            echo '<form action="" method="get">'; // Dodany tag formularza
            echo '<div class="input-group mb-3">';
                echo '<input type="text" name="search" class="form-control" placeholder="Dosępne miasta: Gdańsk, Kraków, Wrocław lub wyszukaj nazwy">';
                echo '<button class="btn btn-primary" type="submit">Szukaj</button>';
            echo '</div>';
            echo '</form>'; // Zamknięcie tagu formularza
        echo '</div>';
    echo '</div>';
echo '</div>';

// Sprawdzenie, czy wynik zapytania nie jest pusty i wyświetlenie danych
if ($result && $result->num_rows > 0) {
    // Przechodzenie przez każdy rekord
    echo '<table class="table table-striped table-hover">';
    // Dodanie nagłówka tabeli
    echo '<thead class="thead-dark">';
    echo '<tr><th>Miasto</th><th>Nazwa</th><th>Ocena</th><th>Cena</th></tr>';
    echo '</thead>';
    
    // Przechodzenie przez każdy rekord i dodanie go do tabeli
    echo '<tbody>';
    while($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($row["hotelMiasto"]). '</td>';
        echo '<td>' . htmlspecialchars($row["hotelNazwa"]). '</td>';
        echo '<td>' . htmlspecialchars($row["hotelOcena"]). '</td>';
        echo '<td>' . htmlspecialchars($row["hotelCena"]). ' zł</td>';
        echo '</tr>';
    }
    echo '</tbody>';
    // Zakończenie tabeli
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