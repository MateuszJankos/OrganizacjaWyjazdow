<?php
include_once 'ALLheader.php'; // Dołączenie nagłówka strony
require_once '../includes/dbh.inc.php'; // Połączenie z bazą danych

if (isset($_POST['createGroup']) && isset($_SESSION['userid'])) {
    $groupName = htmlspecialchars($_POST['groupName']);
    $groupDescription = htmlspecialchars($_POST['groupDescription']);
    $userId = $_SESSION['userid']; // Pobierz ID zalogowanego użytkownika

    // Rozpocznij transakcję
    $conn->begin_transaction();

    try {
        // Wstaw nową grupę do tabeli `grupa`
        $stmt = $conn->prepare("INSERT INTO grupa (Nazwa_Grupy, Opis_Grupy) VALUES (?, ?)");
        $stmt->bind_param("ss", $groupName, $groupDescription);
        $stmt->execute();

        // Pobierz ID nowo utworzonej grupy
        $groupId = $conn->insert_id;

        // Dodaj zalogowanego użytkownika jako uczestnika grupy
        $stmt = $conn->prepare("INSERT INTO uczestnik_grupy (usersId, ID_Grupy) VALUES (?, ?)");
        $stmt->bind_param("ii", $userId, $groupId);
        $stmt->execute();

        // Zatwierdź transakcję
        $conn->commit();

    } catch (Exception $e) {
        // W razie błędu, wycofaj transakcję
        $conn->rollback();

        // Obsługa błędów
        header('Location: grupy.php?error=' . $e->getMessage());
        exit();
    }
}
?>

<main class="container">
    <h2>Utwórz nową grupę</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group">
            <label for="groupName">Nazwa grupy</label>
            <input type="text" class="form-control" id="groupName" name="groupName" required>
        </div>
        <div class="form-group">
            <label for="groupDescription">Opis grupy</label>
            <textarea class="form-control" id="groupDescription" name="groupDescription" required></textarea>
        </div>
        <button type="submit" name="createGroup" class="btn btn-primary">Utwórz grupę</button>
    </form>

    <?php
// Pobranie ID zalogowanego użytkownika (zakładamy, że jest przechowywane w sesji)
if (isset($_SESSION['userid'])) {
    $userId = $_SESSION['userid']; // Pobierz ID zalogowanego użytkownika

    // Pobranie parametrów wyszukiwania i sortowania
    $searchTerm = $_GET['search'] ?? '';
    $sortColumn = $_GET['sort'] ?? 'Nazwa_Grupy';
    $sortOrder = isset($_GET['order']) && $_GET['order'] === 'desc' ? 'DESC' : 'ASC';

    // Bezpieczne sortowanie
    $allowedSortColumns = ['Nazwa_Grupy', 'Opis_Grupy'];
    if (!in_array($sortColumn, $allowedSortColumns)) {
        $sortColumn = 'Nazwa_Grupy'; // Domyślna kolumna sortowania
    }

    // Zabezpieczenie przed SQL Injection
    $searchTermEscaped = $conn->real_escape_string($searchTerm);

    // Zapytanie SQL z opcjonalnym wyszukiwaniem i sortowaniem
    $sql = "SELECT grupa.Nazwa_Grupy, grupa.Opis_Grupy, grupa.ID_Grupy 
            FROM grupa
            INNER JOIN uczestnik_grupy ON grupa.ID_Grupy = uczestnik_grupy.ID_Grupy
            WHERE uczestnik_grupy.usersId = '$userId'";

    if (!empty($searchTerm)) {
        $sql .= " AND (grupa.Nazwa_Grupy LIKE '%$searchTermEscaped%' OR grupa.Opis_Grupy LIKE '%$searchTermEscaped%')";
    }

    $sql .= " ORDER BY $sortColumn $sortOrder";

    $result = $conn->query($sql);
}
?>

<main class="container">
    <!-- Formularz utworzenia nowej grupy... -->
    <!-- ... -->

    <h3>Moje grupy</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Nazwa grupy</th>
                <th>Opis grupy</th>
                <th>Akcje</th>
            </tr>
        </thead>
        <tbody>
        <?php 
$groups = []; // Zdefiniuj $groups jako pustą tablicę, aby uniknąć ostrzeżeń, jeśli nie zostaną znalezione żadne grupy

$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    // Wypisanie grup
    while ($row = $result->fetch_assoc()) {
        $groups[] = $row; // Dodaj każdy wynik do tablicy $groups
    }
}

// Później, gdzie używasz pętli foreach do iterowania przez grupy:
if (!empty($groups)) {
    foreach ($groups as $group) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($group["Nazwa_Grupy"]) . "</td>";
        echo "<td>" . htmlspecialchars($group["Opis_Grupy"]) . "</td>";
        // Formularz z przyciskiem do opuszczenia grupy
        echo "<td>
                <form action='leaveGroup.php' method='post'>
                    <input type='hidden' name='groupId' value='" . $group['ID_Grupy'] . "'>
                    <button type='submit' name='leaveGroup' class='btn btn-danger'>Odejdź z grupy</button>
                </form>
              </td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='3'>Nie znaleziono grup dla tego użytkownika.</td></tr>";
}
?>
        </tbody>
    </table>
</main>

<?php
include_once 'ALLfooter.php'; // Dołączenie stopki strony
?>