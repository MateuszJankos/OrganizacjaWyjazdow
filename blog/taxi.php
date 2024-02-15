<?php 
  include_once 'ALLheader.php';
?>

<main class="container">
  <div class="container mt-5">
    <div class="row">
      <div class="col-md-8 offset-md-2">
        <div class="p-4 p-md-5 mb-4 rounded text-body-emphasis bg-body-secondary" style="background-size: cover; background-position: center;">
          <div class="col-lg-12">
            <h1 class="display-6 fst-italic">Wybierz miasto:</h1>
            <form id="searchForm">
              <div class="form-group">
                <input type="text" class="form-control" id="city" placeholder="Podaj miasto">
              </div>
              <button type="button" class="btn btn-primary mt-3" onclick="search()">Wyszukaj</button>
            </form>
            <p id="phoneNumber" class="mt-3"></p>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <script>
    function search() {
      var cityInput = document.getElementById('city').value.toLowerCase();
      var phoneNumberElement = document.getElementById('phoneNumber');
  
      // Reset phone number display
      phoneNumberElement.textContent = "";
  
      // sprawdza miasto i wypisuje nr
      if (cityInput === "warszawa") {
        phoneNumberElement.textContent = "Tel.: 820-362-612,  508-707-235,  508-901-234 - Taxi Warszawa";
      } else if (cityInput === "gdańsk") {
        phoneNumberElement.textContent = "Tel.: 618-901-234,  513-505-789,  513-456-789 - Taxi Gdańsk";
      } else if (cityInput === "radom") {
        phoneNumberElement.textContent = "Tel.: 630-123-456,  519-212-345,  519-012-345 - Taxi Radom";
      } else if (cityInput === "lublin") {
        phoneNumberElement.textContent = "Tel.: 830-123-456,  528-999-234,  528-901-234 - Taxi Lublin";
      } else if (cityInput === "szczecin") {
        phoneNumberElement.textContent = "Tel.: 530-123-456,  521-228-567,  521-234-567 - Taxi Szczecin";
      } else if (cityInput === "poznań") {
        phoneNumberElement.textContent = "Tel.: 529-012-345,  525-678-901,  525-678-901 - Taxi Poznań";
      } else if (cityInput === "łódź") {
        phoneNumberElement.textContent = "Tel.: 509-012-345,  529-600-345,  529-012-345 - Taxi Łódź";
      } else if (cityInput === "kraków") {
        phoneNumberElement.textContent = "Tel.: 930-123-456,  530-444-456,  530-123-456 - Taxi Kraków";
      } else if (cityInput === "wrocław") {
        phoneNumberElement.textContent = "Tel.: 630-123-456,  511-605-567,  511-234-567 - Taxi Wrocław";
      } else {
        phoneNumberElement.textContent = "Tel.: 771-461-601,  507-890-123,  504-567-890 - Taxi Polska";
      }
    }
  </script>

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