<?php
session_start();
include "./config/db.php";
$database = new Database();
$db = $database->connect();

$channelQuery = $db->query("SELECT id, name FROM channels ORDER BY id ASC");
$channels = $channelQuery->fetchAll();

// Ustaw domyślny kanał (pierwszy na liście)
$channel_id = isset($_GET["channel_id"])
    ? intval($_GET["channel_id"])
    : (isset($channels[0]["id"])
        ? $channels[0]["id"]
        : null);

if ($channel_id) {
    $currentChannel = array_filter($channels, function ($ch) use ($channel_id) {
        return $ch["id"] == $channel_id;
    });
    $currentChannel = reset($currentChannel);
}
?>
<!DOCTYPE html>
<html lang="pl">
<?php include "components/head.php"; ?>
<body>
<div class="container-fluid">
        <div class="row">
            <!-- Pasek boczny -->
            <div class="col-md-3 bg-dark p-3 position-relative" style="height: 100vh;">
                <h4 class="text-white">Kanały</h4>
                <ul class="list-group">
                    <?php foreach ($channels as $ch): ?>
                        <li class="list-group-item <?php echo $ch["id"] ==
                        $channel_id
                            ? "active"
                            : ""; ?> p-0">
                            <a href="?channel_id=<?php echo $ch[
                                "id"
                            ]; ?>" class="channel-link text-white d-block p-2 ps-3" style="text-decoration: none">
                                # <?php echo htmlspecialchars($ch["name"]); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>

                <!-- Przycisk do dodawania nowego kanału -->
                <div class="d-flex justify-content-around w-100">
                    <button class="btn btn-success mt-2" data-bs-toggle="modal" data-bs-target="#createChannelModal">
                        <i class="bi bi-plus-circle"></i> Dodaj kanał
                    </button>
                    <button type="button" class="btn btn-danger mt-2 delete-channel" data-id="<?php echo $ch[
                        "id"
                    ]; ?>" data-name="<?php echo htmlspecialchars(
    $ch["name"]
); ?>" data-bs-toggle="modal" data-bs-target="#deleteChannelModal">
                        <i class="bi bi-trash"></i> Usuń Kanał
                    </button>
                </div>

                <!-- Okno użytkownika -->
                <div class="user-panel d-flex align-items-center justify-content-around position-absolute bg-dark p-3">
                    <div>
                        <i class="bi bi-person-circle">
                            <a href="./index.php" style="text-decoration: none" class="text-white"></a>
                        </i>
                        <h6 class="text-white">
                            <?php echo isset($_SESSION["username"])
                                ? htmlspecialchars($_SESSION["username"])
                                : '<a href="./index.php" style="text-decoration: none"' .
                                    'class="text-white">Gość</a>'; ?>
                            <?php if (isset($_SESSION["username"])): ?>
                        </h6>
                    </div>
                    <div>
                        <a href="./config/logout.php" class="btn btn-danger">
                            <i class="bi bi-box-arrow-right"></i>
                        </a>
                    <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Główna część czatu -->
            <div class="col-md-9 p-3">
                <?php if ($channel_id): ?>
                <h3 class="mb-3 text-white">Czat - #<?php echo htmlspecialchars(
                    $channels[0]["name"]
                ); ?></h3>
                <div class="border p-3 mb-3" style="height: 400px; overflow-y: scroll; background-color: #3B4048;">
                    <?php foreach ($messages as $message): ?>
                        <p><strong style="color: #98C379;">
                                <?php echo htmlspecialchars(
                                    $message["username"]
                                ); ?>:</strong>
                            <?php echo htmlspecialchars($message["message"]); ?>
                            <small class="text-muted">(<?php echo $message[
                                "sent_at"
                            ]; ?>)</small></p>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <!-- Formularz wysyłania wiadomości -->
                <form action="./config/send_message.php" method="POST">
                    <input type="hidden" name="channel_id" value="<?php echo $channel_id; ?>">
                    <div class="input-group">
                        <input type="text" name="message" class="form-control" placeholder="Napisz wiadomość..." required>
                        <button class="btn btn-primary" type="submit">Wyślij</button>
                    </div>
                </form>
            </div>
        </div>

    <?php include "./components/create_channel_modal.php"; ?>

    <?php include "./components/delete_channel_modal.php"; ?>

    <!--Skrypt, który odświeża wiadomości-->
    <script>
        function fetchMessages() {
            fetch('./config/fetch_message.php?channel_id=<?php echo $channel_id; ?>')
                .then(response => response.json())
                .then(data => {
                    let messagesContainer = document.querySelector('.border.p-3.mb-3');
                    messagesContainer.innerHTML = '';
                    data.forEach(msg => {
                        messagesContainer.innerHTML += `<p><strong style="color: #98C379;">${msg.username}:</strong> ${msg.message} <small class="text-muted">(${msg.sent_at})</small></p>`;
                    });
                    messagesContainer.scrollTop = messagesContainer.scrollHeight;
                });
        }
        setInterval(fetchMessages, 900);
    </script>
    <script src="./js/delete_channel.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
