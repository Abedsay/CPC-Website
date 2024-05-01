function showSection(sectionId, event) {
    // Prevent default link behavior
    event.preventDefault();

    // Hide all sections in the left column
    var leftColumnSections = document.querySelector('.left-column').getElementsByClassName('content-section');
    for (var i = 0; i < leftColumnSections.length; i++) {
        leftColumnSections[i].style.display = 'none';
    }

    // Show the selected section
    document.getElementById(sectionId).style.display = 'block';

    // Update active link styling
    var links = document.querySelectorAll('.navigation a');
    links.forEach(link => {
        link.classList.remove('active');
    });
    event.currentTarget.classList.add('active');
}





document.getElementById('uploadForm').addEventListener('submit', function (event) {
    event.preventDefault(); // Prevent the default form submission

    // Here, you would normally handle the file upload with AJAX
    alert('The test results have been uploaded successfully.');

    // Reset the form after the file is 'uploaded'
    event.target.reset();
});

document.addEventListener('DOMContentLoaded', function () {
    var chatHistories = {
        'doctor1': [
            { text: "Hello, how can I assist you today?", time: "14:30", sentBy: "doctor" },
            { text: "I need information on my prescription.", time: "14:35", sentBy: "user" }
        ],
        'doctor2': [
            { text: "Your next appointment is scheduled for Monday.", time: "09:30", sentBy: "doctor" }
        ],
        'doctor3': [
            { text: "Your next appointment is scheduled for Tuesday.", time: "09:30", sentBy: "doctor" }
        ]
    };

    // Event listener for contact clicks
    document.querySelectorAll('.contact').forEach(contact => {
        contact.addEventListener('click', function () {
            var doctorId = this.getAttribute('data-doctor-id');
            openChat(doctorId);
        });
    });

    function openChat(doctorId) {
        var chatHistory = chatHistories[doctorId] || [];
        updateChatArea(chatHistory);
    }

    function updateChatArea(messages) {
        var chatArea = document.querySelector('.chat-messages');
        chatArea.innerHTML = ''; // Clear current messages

        messages.forEach(function (message) {
            var messageElement = document.createElement('div');
            messageElement.classList.add('message');
            messageElement.classList.add(message.sentBy === 'user' ? 'sent' : 'received');
            messageElement.innerHTML = `
        <p>${message.text}</p>
        <span class="message-time">${message.time}</span>
    `;
            chatArea.appendChild(messageElement);
        });

        chatArea.scrollTop = chatArea.scrollHeight; // Scroll to the bottom of the chat
    }
});
document.querySelectorAll('.decrease-quantity').forEach(button => {
button.addEventListener('click', function() {
    var quantityElement = this.nextElementSibling;
    var quantity = parseInt(quantityElement.textContent, 10);
    if (quantity > 0) quantityElement.textContent = quantity - 1;
});
});

document.querySelectorAll('.increase-quantity').forEach(button => {
button.addEventListener('click', function() {
    var quantityElement = this.previousElementSibling;
    var quantity = parseInt(quantityElement.textContent, 10);
    quantityElement.textContent = quantity + 1;
});
});

document.getElementById('save-button').addEventListener('click', function() {
// Here you would typically send the data to the server
alert('Storage adjustments have been saved!');
});