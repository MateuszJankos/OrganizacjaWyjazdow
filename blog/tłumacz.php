<?php 
  include_once 'ALLheader.php';
?>

<main class="container">
  <div class="container mt-5">
    <h1 class="text-center mb-4">Language Translator</h1>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <label for="inputLanguage" class="form-label">Wybierz język:</label>
            <select class="form-select mb-3" id="inputLanguage">
                <option value="en">Angielski</option>
                <option value="es">Niemiecki</option>
                <option value="en">Polski</option>
                <option value="fr">Francuski</option>
                <option value="fr">Hiszpański</option>
                <option value="fr">Włoski</option>

            </select>

            <label for="outputLanguage" class="form-label">Przetłumacz na:</label>
            <select class="form-select mb-3" id="outputLanguage">
                <option value="en">Polski</option>
                <option value="en">Angielski</option>
                <option value="es">Niemiecki</option>
                <option value="fr">Francuski</option>
                <option value="fr">Hiszpański</option>
                <option value="fr">Włoski</option>

                
            </select>

            <label for="inputText" class="form-label">Wpisz tekst:</label>
            <textarea class="form-control mb-3" id="inputText" rows="3"></textarea>

            <button class="btn btn-primary mb-3" onclick="translate()">Tłumacz</button>
            <br>
            <label for="outputText" class="form-label mt-3">Tłumaczenie:</label>
            <textarea class="form-control mb-3" id="outputText" rows="3" readonly></textarea>
        </div>
    </div>
</div>
      
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function translate() {
        // Add your translation logic here
        // You can use a translation API or any other method to perform the translation
        // Update the content of the "outputText" textarea with the translated text
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