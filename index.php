<?php
session_start();
include './config/db.php';
$database = new Database();
$db = $database->connect();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    try {
        $stmt = $db->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch();
        if ($user) {
            echo "Użytkownik znaleziony.";
        } else {
            echo "Użytkownik nie znaleziony.";
        }
    } catch (PDOException $e) {
        echo "Błąd: " . $e->getMessage();
    }

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['username'] = $user['username'];
        header("Location: general_page.php");
        exit();
    } else {
        $error = "Nieprawidłowa nazwa użytkownika lub hasło!";
    }
}
?>

<!DOCTYPE html>
<html lang="pl">
<?php
include 'components/head.php';
?>
<body class="bg-black">
<style>
    body{
        background: url('./img/cool-background.png') no-repeat;
    }
</style>
<div class="container d-flex justify-content-center align-content-center align-items-center" style="height: 100vh;">
    <div class="card bg-dark" style="width: 18re,;">
        <div class="card-body bg-black">
            <h2 class="card-title text-white text-center">Witaj w Pluck!</h2>

            <p class="card-text text-center text-white">Zaloguj się, aby korzystać z czatu.</p>
            <div class="card-text">
                <?php if (isset($error)) echo "<p class='text-danger'>$error</p>"; ?>
                <form action="index.php" method="POST">
                    <input type="text" name="username" class="form-control mb-2" placeholder="Nazwa użytkownika" required>
                    <input type="password" name="password" class="form-control mb-2" placeholder="Hasło" required>
                    <button type="submit" class="btn btn-primary w-100">Zaloguj się</button>
                </form>
                <p class="text-center mt-2"><a href="register.php">Nie masz konta? Zarejestruj się</a></p>
            </div>
        </div>
    </div>
</div>
</body>
</html>
