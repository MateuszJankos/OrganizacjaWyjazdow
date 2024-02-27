<?php
include_once 'ALLheader.php'; // Dołączenie nagłówka strony
require_once '../includes/dbh.inc.php'; // Dołączenie połączenia z bazą danych

// Sprawdzenie, czy użytkownik jest zalogowany
if (!isset($_SESSION['userid'])) {
    header("Location: login.php"); // Przekierowanie do strony logowania
    exit();
}

// Sprawdzenie, czy formularz został przesłany
if (isset($_POST['addMessage'])) {
    $messageContent = $_POST['messageContent'];
    $tripId = $_POST['tripId'];
    $userId = $_SESSION['userid'];

    // Walidacja danych wejściowych (możesz dodać bardziej szczegółową walidację)
    if (empty($messageContent) || empty($tripId)) {
        // Obsługa błędu, gdy jakiekolwiek pole jest puste
        header("Location: message.php?error=emptyfields");
        exit();
    }

    // Zapytanie do bazy danych
    $sql = "INSERT INTO wiadomosc (Tresc, Data_Wyslania, ID_Wyjazdu, ID_Nadawcy) VALUES (?, NOW(), ?, ?)";

    // Przygotowanie zapytania
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        // Obsługa błędu przygotowania zapytania
        header("Location: message.php?error=sqlerror");
        exit();
    }

    // Przypisanie parametrów do zapytania
    $stmt->bind_param("sii", $messageContent, $tripId, $userId);

    // Wykonanie zapytania
    $stmt->execute();

    if ($stmt->affected_rows === 0) {
        // Obsługa błędu, gdy nie dodano wiadomości
        header("Location: message.php?error=messagefailed");
        exit();
    } else {
        // Przekierowanie do strony z potwierdzeniem
        header("Location: message.php?success=messageadded");
    }

    // Zamknięcie zapytania
    $stmt->close();
}

// Pobranie wyjazdów powiązanych z grupami, do których należy użytkownik
$userId = $_SESSION['userid'];
$tripsQuery = "SELECT wyjazd.ID_Wyjazdu, wyjazd.Data_Startu FROM wyjazd
               JOIN uczestnik_grupy ON wyjazd.ID_Grupy = uczestnik_grupy.ID_Grupy
               WHERE uczestnik_grupy.usersId = ?";
$stmt = $conn->prepare($tripsQuery);
$stmt->bind_param("i", $userId);
$stmt->execute();
$tripsResult = $stmt->get_result();
$trips = $tripsResult->fetch_all(MYSQLI_ASSOC);
?>

<div class="container mt-5">
    <h2>Dodaj wiadomość do wyjazdu</h2>
    <form action="addmessage.php" method="post">
        <div class="form-group">
            <label for="ID_Wyjazdu">Wyjazd</label>
            <select class="form-control" id="ID_Wyjazdu" name="ID_Wyjazdu" required>
                <?php foreach ($trips as $trip): ?>
                    <option value="<?= htmlspecialchars($trip['ID_Wyjazdu']) ?>"><?= htmlspecialchars($trip['Data_Startu']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="Tresc">Treść wiadomości</label>
            <textarea class="form-control" id="Tresc" name="Tresc" required></textarea>
        </div>
        <button type="submit" name="addMessage" class="btn btn-primary">Dodaj wiadomość</button>
    </form>
</div>

<?php
include_once 'ALLfooter.php'; // Dołączenie stopki strony
?>