<?php
// Przed rozpoczęciem sesji upewnij się, że sesja została już uruchomiona w pliku, który dołącza ten skrypt.
// session_start(); // Odkomentuj, jeśli sesja nie jest jeszcze uruchomiona.

// Pobranie nazwy grupy na podstawie ID_Grupy z sesji
$groupId = $_SESSION['selectedGroupId'];
$groupName = ''; // Zmienna na nazwę grupy

// Zapytanie do bazy danych o nazwę grupy na podstawie ID_Grupy
require_once '../includes/dbh.inc.php'; // Połączenie z bazą danych, zakładam że jest już wcześniej zaincludowane.
if ($stmt = $conn->prepare("SELECT Nazwa_Grupy FROM grupa WHERE ID_Grupy = ?")) {
    $stmt->bind_param("i", $groupId);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $groupName = $result->fetch_assoc()['Nazwa_Grupy'];
    } else {
        echo "Nie znaleziono grupy.";
        // Możesz również przekierować użytkownika z powrotem do strony wyboru grupy lub wykonać inną akcję.
    }
    $stmt->close();
} else {
    echo "Błąd zapytania do bazy danych: " . $conn->error;
}
?>

<h3>Stwórz nowy wyjazd w grupie <?= htmlspecialchars($groupName) ?></h3>
<form action="create_trip.php" method="post">
    <input type="hidden" name="groupId" value="<?= htmlspecialchars($groupId) ?>">
    <!-- Możesz również przechować nazwę grupy w ukrytym polu, jeśli jest potrzebna w create_trip.php -->
    <input type="hidden" name="groupName" value="<?= htmlspecialchars($groupName) ?>">
    <div class="form-group">
        <label for="startDate">Data rozpoczęcia</label>
        <input type="date" class="form-control" id="startDate" name="startDate" required>
    </div>
    <div class="form-group">
        <label for="endDate">Data zakończenia</label>
        <input type="date" class="form-control" id="endDate" name="endDate" required>
    </div>
    <button type="submit" name="createTrip" class="btn btn-success mt-3">Stwórz wyjazd</button>
</form>