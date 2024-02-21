<?php
include_once 'ALLheader.php'; // Dołączenie nagłówka strony
require_once '../includes/dbh.inc.php'; // Połączenie z bazą danych

$messageSent = false;

$tripSelected = isset($_POST['trip']) && $_POST['trip'] === "Wyjazd 01.03.2024";

// Logika wysyłania wiadomości na podstawie wysłanego formularza
if ($tripSelected && isset($_POST['message'])) {
    $messageSent = true;
    $message = htmlspecialchars($_POST['message']);
    // Tutaj należałoby dodać logikę obsługi wysyłania wiadomości do bazy danych lub innego systemu
}
?>

<div class="container mt-5">
    <h2>Wybierz wyjazd</h2>
    <form action="" method="post">
        <div class="form-group">
            <label for="trip">Wyjazd</label>
            <select class="form-select" id="trip" name="trip">
                <option value="Wyjazd 01.03.2024">Wyjazd 01.03.2024</option>
            </select>
        </div>
        <button type="submit" name="selectTrip" class="btn btn-primary mt-3">Wybierz wyjazd</button>
    </form>

    <?php if ($tripSelected): ?>
        <h3>Wyślij wiadomość do Grupy</h3>
        <form action="" method="post">
            <input type="hidden" name="trip" value="Wyjazd 01.03.2024">
            <div class="form-group">
    <label for="message">Wiadomość</label>
    <textarea class="form-control" id="message" name="message" required style="height: 200px;"></textarea>
</div>

            <button type="submit" name="sendMessage" class="btn btn-success mt-3">Wyślij</button>
        </form>
    <?php endif; ?>

    <?php if ($messageSent): ?>
        <div class="alert alert-success mt-3" role="alert">
            Twoja wiadomość została wysłana.
        </div>
    <?php endif; ?>
</div>

<?php
include_once 'ALLfooter.php'; // Dołączenie stopki strony
?>