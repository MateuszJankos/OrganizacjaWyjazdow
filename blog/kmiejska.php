<?php 
  include_once 'ALLheader.php';
?>

<main class="container">
  <div class="container mt-5">
    <div class="row">
      <div class="col-md-8 offset-md-2">
        <div class="p-4 p-md-5 mb-4 rounded text-body-emphasis bg-body-secondary" style="background-size: cover; background-position: center;">
          <div class="col-lg-12">
            <h1 class="display-6 fst-italic">Kup bilet miejski / Wyszukaj trasę</h1>
            <form>
              <div class="form-group">
                <label for="ticketType">Rodzaj biletu:</label>
                <select class="form-control" id="ticketType">
                  <option value="singleTicket">Bilet 20 minutowy</option>
                  <option value="singleTicket">Bilet 75 minutowy</option>
                  <option value="dailyPass">Bilet całodniowy</option>
                  <option value="monthlyPass">Karnet 3 dniowy</option>
                </select>
              </div>
              <div class="form-group">
                <label for="departureLocation">Miejsce rozpoczęcia podróży:</label>
                <input type="text" class="form-control" id="departureLocation" placeholder="Podaj miejsce rozpoczęcia podróży">
              </div>
              <div class="form-group">
                <label for="destination">Cel podróży:</label>
                <input type="text" class="form-control" id="destination" placeholder="Podaj cel podróży">
              </div>
              <div class="form-group">
                <label for="passengerCount">Ilość biletów:</label>
                <input type="number" class="form-control" id="passengerCount" placeholder="Podaj ilość biletów">
              </div>
              <div class="form-group">
                <label for="Ticketvalue">Ulga:</label>
                <select class="form-control" id="Ticketvalue">
                  <option value="creditCard">Normalny</option>
                  <option value="cash">Ulgowy 51%</option>
                </select>
              </div>
              <div class="form-group">
                <label for="paymentMethod">Metoda płatności:</label>
                <select class="form-control" id="paymentMethod">
                  <option value="blik">Płatność Blik</option>
                  <option value="creditCard">Karta kredytowa</option>
                </select>
              </div>
              <button type="submit" class="btn btn-primary mt-3">Kup bilet / Wyszukaj trasę</button>
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