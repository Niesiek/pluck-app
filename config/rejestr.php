<?php
session_start();
include './config/db.php';
$database = new Database();
$db = $database->connect();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $query = $db->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");

    if ($query->execute([$username, $email, $password])) {
        $_SESSION['username'] = $username;
        header("Location: ./index.php");
        exit();
    } else {
        $error = "Błąd rejestracji!";
    }
}


