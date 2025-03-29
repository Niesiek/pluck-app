<div class="modal fade" id="deleteChannelModal" tabindex="-1" aria-labelledby="deleteChannelModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-dark text-white">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteChannelModalLabel">Usuń kanał</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Czy na pewno chcesz usunąć kanał <strong id="channelNameToDelete"></strong>?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Anuluj</button>
                <form action="./config/delete_channel.php" method="POST">
                    <input type="hidden" name="channel_id" id="channelIdToDelete">
                    <button type="submit" class="btn btn-danger">Usuń</button>
                </form>
            </div>
        </div>
    </div>
</div>

