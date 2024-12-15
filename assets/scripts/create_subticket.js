// Dynamically add a sub-ticket to the list
function addSubticket(event) {
    event.preventDefault(); // Prevent the form from reloading the page

    // Get form values
    const title = document.getElementById('subticket-title').value;
    const assignee = document.getElementById('assignee').value;
    const description = document.getElementById('description').value;

    // Create a new list item
    const listItem = document.createElement('li');
    listItem.classList.add('subticket-item');

    listItem.innerHTML = `
        <h4>${title}</h4>
        <p><strong>Assigned to:</strong> ${assignee.replace('-', ' ')}</p>
        <p><strong>Description:</strong> ${description}</p>
    `;

    // Add the new item to the list
    document.getElementById('subticket-list').appendChild(listItem);

    // Clear the form and close the modal
    document.getElementById('subticket-form').reset();
    closeModal();
}