<?php
session_start();
include 'db.php';
$database = new Database();
$db = $database->connect();

if (!isset($_GET['channel_id'])) {
    echo "Błąd: Brak ID kanału.";
    exit();
}

$channel_id = $_GET['channel_id'];

$messageQuery = $db->prepare("SELECT messages.message, users.username, messages.sent_at FROM messages 
                              JOIN users ON messages.user_id = users.id
                              WHERE messages.channel_id = ? ORDER BY messages.sent_at ASC");
$messageQuery->execute([$channel_id]);
$messages = $messageQuery->fetchAll();

header('Content-Type: application/json');
echo json_encode($messages);
