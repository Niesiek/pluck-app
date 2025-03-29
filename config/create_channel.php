<?php
session_start();
include 'db.php';
$database = new Database();
$db = $database->connect();

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['channelName'])) {
    $channelName = htmlspecialchars(trim($_POST['channelName']));

    if (!empty($channelName)) {
            $stmt = $db->prepare("INSERT INTO channels (name) VALUES (:name)");
            $stmt->execute([':name' => $channelName]);
            header("Location: ./../general_page.php");
            exit();

    }
}

