<?php 
  include_once 'ALLheader.php';
?>

<main class="container">
  <div class="container mt-5">
    <div class="row">
      <div class="col-md-8 offset-md-2">
        <div class="p-4 p-md-5 mb-4 rounded text-body-emphasis bg-body-secondary" style="background-size: cover; background-position: center;">
          <div class="col-lg-12">
            <h1 class="display-6 fst-italic">Znajdź hotel</h1>
            <form>
              <div class="form-group">
                <label for="departureLocation">Miejsce: </label>
                <input type="text" class="form-control" id="location" placeholder="Gdzie zamierzasz jechać?">
              </div>
              <div class="form-group">
                <label for="destination">Data zameldowania:</label>
                <input type="date" class="form-control" id="firstday" placeholder="">
              </div>
              <div class="form-group">
                <label for="passengerCount">Data Wymeldowania:</label>
                <input type="date" class="form-control" id="lastday" placeholder="">
              </div>
              <div class="form-group">
                <label for="passengerCount">Dorośli:</label>
                <input type="number" class="form-control" id="adults" placeholder="1">
              </div>
              <div class="form-group">
                <label for="passengerCount">Dzieci:</label>
                <input type="number" class="form-control" id="kids" placeholder="0">
              </div>
              <div class="form-group">
                <label for="passengerCount">Ilość pokoi:</label>
                <input type="number" class="form-control" id="rooms" placeholder="1">
              </div>
              <button type="submit" class="btn btn-primary mt-3">Wyszukaj</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
      
  
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