<div class="modal fade" id="createChannelModal" tabindex="-1" aria-labelledby="createChannelModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-dark text-white">
            <div class="modal-header">
                <h5 class="modal-title" id="createChannelModalLabel">Utwórz nowy kanał</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="./config/create_channel.php" method="POST">
                    <div class="mb-3">
                        <label for="channelName" class="form-label">Nazwa kanału</label>
                        <input type="text" class="form-control" id="channelName" name="channelName" required>
                    </div>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cofnij</button>
                    <button type="submit" class="btn btn-success">Utwórz</button>

                </form>
            </div>
        </div>
    </div>
</div>
