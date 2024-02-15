<?php 
  include_once 'ALLheader.php';
?>

<main class="container">
  <div class="container mt-5">
    <h1 class="text-center mb-4">Wyszukaj najbliższe atrakcje</h1>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Enter your location" id="locationInput">
                <button class="btn btn-primary" onclick="searchAttractions()">Szukaj</button>
            </div>

            <ul class="list-group" id="attractionsList">
                <!-- Results will be dynamically added here -->
            </ul>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function searchAttractions() {
        // Add your logic to search for nearby attractions based on the entered location
        // You can use a location-based API or any other method to fetch attractions
        // Update the content of the "attractionsList" with the search results dynamically
        // For example, you can use JavaScript to create and append list items to the "attractionsList" ul
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