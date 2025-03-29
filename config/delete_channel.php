<?php
session_start();
include 'db.php';
$database = new Database();
$db = $database->connect();

// Sprawdź, czy użytkownik jest zalogowany
if (!isset($_SESSION['username'])) {
    echo "Błąd: Musisz być zalogowany, aby usunąć kanał.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['channel_id'])) {
    $channel_id = intval($_POST['channel_id']);

    // Najpierw usuń wszystkie wiadomości z kanału
    $deleteMessagesQuery = $db->prepare("DELETE FROM messages WHERE channel_id = :channel_id");
    $deleteMessagesQuery->execute([ ':channel_id' => $channel_id]);

    // Następnie usuń sam kanał
    $deleteChannelQuery = $db->prepare("DELETE FROM channels WHERE id = :channel_id");
    $deleteChannelQuery->execute([':channel_id'=>$channel_id]);

    if ($deleteChannelQuery->execute([':channel_id'=>$channel_id])) {
        header("Location: ./../general_page.php");
        exit();
    } else {
        echo "Błąd: Nie udało się usunąć kanału.";
    }
} else {
    echo "Błąd: Nieprawidłowe żądanie.";
}

