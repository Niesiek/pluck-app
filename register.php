<?php
session_start();
include './config/db.php';
$database = new Database();
$db = $database->connect();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    try {
        $stmt = $db->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
        $stmt->execute([
            'username' => $username,
            'email' => $email,
            'password' => $password
        ]);
        header("location: general_page.php");
    }catch (PDOException $e){
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="pl">
<?php
    include 'components/head.php';
?>
<body>

<div class="container">
    <div class="">
        <h2 class="text-center">Rejestracja</h2>
        <?php if (isset($error)) echo "<p class='text-danger'>$error</p>"; ?>
        <form action="register.php" method="POST">
            <input type="text" name="username" class="form-control mb-2" placeholder="Nazwa użytkownika" required>
            <input type="email" name="email" class="form-control mb-2" placeholder="Email" required>
            <input type="password" name="password" class="form-control mb-2" placeholder="Hasło" required>
            <button type="submit" class="btn btn-primary w-100">Zarejestruj się</button>
        </form>
            <p class="text-center mt-2"><a href="login.php">Masz już konto? Zaloguj się</a></p>
    </div>
</div>
</body>
</html>
