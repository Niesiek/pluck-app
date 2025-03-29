<?php
session_start();
include 'db.php';
$database = new Database();
$db = $database->connect();

if (!isset($_SESSION['username'])) {
    echo "Błąd: Musisz być zalogowany, aby wysyłać wiadomości.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $channel_id = $_POST['channel_id'];
    $message = trim($_POST['message']);
    $username = $_SESSION['username'];

    if (empty($message)) {
        echo "Błąd: Wiadomość nie może być pusta.";
        exit();
    }

    // Pobierz ID użytkownika na podstawie nazwy użytkownika
    $userQuery = $db->prepare("SELECT id FROM users WHERE username = ?");
    $userQuery->execute([$username]);
    $user = $userQuery->fetch();

    if (!$user) {
        echo "Błąd: Nie znaleziono użytkownika.";
        exit();
    }

    $user_id = $user['id'];

    // Wstawienie wiadomości do bazy danych
    $query = $db->prepare("INSERT INTO messages (channel_id, user_id, message, sent_at) VALUES (?, ?, ?, NOW())");

    if ($query->execute([$channel_id, $user_id, $message])) {
        // Przekieruj z powrotem do tego samego kanału
        header("Location: ./../general_page.php?channel_id=" . $channel_id);
        exit();
    } else {
        echo "Błąd: Nie udało się wysłać wiadomości.";
    }
}
