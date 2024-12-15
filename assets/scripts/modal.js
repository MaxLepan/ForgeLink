function openModal() {
    document.getElementById('modal').style.display = 'flex';
}

function closeModal() {
    document.getElementById('modal').style.display = 'none';
}

// Open and close the reject modal
function openRejectModal() {
    document.getElementById('reject-modal').style.display = 'flex';
}

function closeRejectModal() {
    document.getElementById('reject-modal').style.display = 'none';
}

// Handle rejection form submission
function handleReject(event) {
    event.preventDefault(); // Prevent page reload

    const reason = document.getElementById('reject-reason').value;

    // Log the reason or send it to the server
    console.log('Ticket rejected for the following reason:', reason);
    alert('Ticket rejected.');

    // Optionally close the modal and clear the form
    document.getElementById('reject-form').reset();
    closeRejectModal();
}