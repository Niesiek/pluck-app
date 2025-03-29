document.addEventListener('DOMContentLoaded', function() {
    const deleteButtons = document.querySelectorAll('.delete-channel');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const channelId = this.getAttribute('data-id');
            const channelName = this.getAttribute('data-name');

            document.getElementById('channelIdToDelete').value = channelId;
            document.getElementById('channelNameToDelete').textContent = channelName;
        });
    });
});