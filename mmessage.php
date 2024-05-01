
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">

        <!-- ... other head elements ... -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    
    
    <style>
         * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }


        html {
            height: 100%;
            font-family: 'Arial', sans-serif;
            background: #F0F2F5;
        }

        /* Main layout styles */

        body {
            display: flex;
            min-height: 100vh;
            font-family: 'Arial', sans-serif;
            background: #F0F2F5;
            margin: 0;
        }

        .main-content {
            flex-grow: 1;
            padding: 20px;
        }

        header {
            background-color: #FFFFFF;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* Styles for vitals and appointments*/
        .vitals,
        .appointments,
        .reports {
            background-color: #FFFFFF;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.1);
        }

        .vitals {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .appointment {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
            padding: 20px;
            border-radius: 8px;
            background-color: #F8F8F8;
        }

        /* Styles for different appointment statuses */
        .status {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 15px;
            color: #fff;
        }

        .status.active {
            background-color: #5CBA47;
        }

        .status.upcoming {
            background-color: #2D9CDB;
        }

        .status.completed {
            background-color: #BDBDBD;
        }

        .sidebar {
            width: 250px;
            background-color: #010C80;
            padding: 20px;
            position:relative;
          
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }

        .sidebar .logo {
            text-align: center;
            padding-bottom: 20px;
        }

        .sidebar img {
             width:100%;
             height:100%;
        }

        .sidebar .navigation {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar .navigation a {
            display: flex;
            align-items: center;
            padding: 10px;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            margin-bottom: 10px;
            transition: background-color 0.3s;
        }

        img {
            width: 60%;
            height: 60%;
            border-radius: 30px;
        }

        .sidebar .navigation a.active,
        .sidebar .navigation a:hover {
            background-color: #4B91F1;
            color: white;
        }

        .sidebar .navigation a i.icon {
            margin-right: 10px;
        }

        .sidebar .help-center {
            position: absolute;
            bottom: 20px; /* Adjust the distance from the bottom */
            width: calc(100% - 40px); /* Make the button full width minus padding */
            text-align: center;
        }

        .sidebar .help-center button {
            background: #4B91F1;
            color: white;
            border: none;
            border-radius: 20px;
            padding: 10px;
            width: 100%;
            display: block;
        }

        .sidebar .help-center button i.icon {
            margin-right: 5px;
        }

        .sidebar .help-center button span {
            display: block;
            font-size: smaller;
        }
        
        .greeting h1,
        .greeting p {
            margin: 0;
        }

        .icon-button {
            background: none;
            border: none;
            font-size: 16px;
            cursor: pointer;
            margin-left: 20px;
            /* Space between icons */
        }

        .user-container {
            display: flex;
            align-items: center;
            cursor: pointer;
        }

        .user-avatar {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            margin-right: 10px;
        }
        .main-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            background-color: #010C80;
            color: white;
        }

        .greeting h1 {
            margin: 0;
            font-size: 1.5rem;
        }

        .greeting p {
            margin: 0;
        }

        .search-and-user {
            display: flex;
            align-items: center;
        }

        .search-container {
            position: relative;
            margin-right: 20px;
        }

        .search-icon,
        .notification-icon {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
        }

        .search-icon {
            left: 10px;
        }

        .notification-icon {
            right: 10px;
        }

        .search-container input {
            padding: 5px 10px 5px 30px;
            /* Left padding to make room for the icon */
            border-radius: 20px;
            border: none;
        }

        .user-container {
            display: flex;
            align-items: center;
            cursor: pointer;
        }

        .user-icon {
            margin-right: 5px;
        }
        .messaging-container {
            display: flex;
            height: 100vh;
            width: 100%;
            background-color: #F0F2F5;
        }

        .contact-list {
            width: 25%;
            background: #fff;
            overflow-y: auto;
            border-right: 1px solid #ddd;
        }

        .chat-area {
            width: 75%;
            display: flex;
            flex-direction: column;
        }

        .chat-header {
            background-color: #f5f5f5;
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #ddd;
        }

        .chat-messages {
            flex-grow: 1;
            overflow-y: auto;
        }

        .chat-input-area {
            padding: 15px;
            background-color: #fff;
            border-top: 1px solid #ddd;
            display: flex;
            align-items: center;
        }

        .chat-input-area input {
            flex-grow: 1;
            padding: 10px;
            border-radius: 20px;
            border: 1px solid #ddd;
            margin-right: 10px;
        }

        .contact-list {
            width: 350px; 
            background-color: #ffffff;
            padding: 20px;
            overflow-y: auto;
            height: 100vh; /* Full height of the viewport */
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.05);
        }

        .search-bar {
            position: relative;
            margin-bottom: 20px;
        }

        .search-bar input {
            width: 100%;
            padding: 10px 40px 10px 20px;
            border-radius: 20px;
            border: 1px solid #e6e6e6;
            font-size: 14px;
        }

        .search-button {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
        }

        .chat-tabs {
            display: flex;
            justify-content: space-around;
            margin-bottom: 20px;
        }

        .tab {
            background: none;
            border: none;
            padding-bottom: 10px;
            cursor: pointer;
            font-weight: bold;
            font-size: 14px;
            color: #9a9a9a;
        }

        .tab.active {
            color: #000000;
            border-bottom: 2px solid #0056b3;
        }

        .contact {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
            padding: 10px;
            border-radius: 10px;
            transition: background-color 0.2s ease-in-out;
            cursor: pointer;
        }

        .contact:hover {
            background-color: #f2f2f2;
        }

        .contact img {
            border-radius: 50%;
            width: 45px;
            height: 45px;
            object-fit: cover;
            margin-right: 10px;
        }

        .contact-info h5 {
            font-size: 16px;
            margin-bottom: 5px;
        }

        .contact-info p {
            font-size: 12px;
            color: #9a9a9a;
        }

        .contact-time {
            margin-left: auto;
            font-size: 12px;
            color: #9a9a9a;
        }
        .chat-area {
            background: #fff;
            display: flex;
            flex-direction: column;
        }

        .chat-header {
            display: flex;
            align-items: center;
            padding: 20px;
            border-bottom: 1px solid #ddd;
            background-color: #f5f5f5;
        }

        .chat-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .chat-info h4 {
            margin: 0;
            font-weight: 500;
        }

        .chat-info p {
            margin: 0;
            font-size: 0.9em;
            color: #4caf50;
        }

        .chat-options {
            margin-left: auto;
        }

        .chat-messages {
            flex-grow: 1;
            padding: 20px;
            overflow-y: auto;
        }

        .message {
            padding: 10px 15px;
            border-radius: 20px;
            margin-bottom: 10px;
            max-width: 60%;
            word-wrap: break-word;
        }

        .message.sent {
            background-color: #e6f7ff;
            align-self: flex-end;
        }

        .message.received {
            background-color: #f0f0f0;
            align-self: flex-start;
        }

        .message-time {
            display: block;
            text-align: right;
            color: #999;
            font-size: 0.8em;
        }

        .chat-input {
            display: flex;
            padding: 10px;
            border-top: 1px solid #ddd;
        }

        .chat-input input {
            flex: 1;
            padding: 10px;
            border-radius: 20px;
            border: 1px solid #ddd;
            margin-right: 10px;
        }

        .send-button {
            border: none;
            background: #0056b3;
            color: #fff;
            padding: 10px 15px;
            border-radius: 20px;
            cursor: pointer;
        }

    </style>

</head>

<body>
    <aside class="sidebar">
        <div class="logo">
            <img src="assets/images/logo.jpg" alt="HealthCare Logo">
        </div>
        <br>
        <nav class="navigation">
            <a href="managerindex.php"><i class="fas fa-tachometer-alt"></i>&nbsp;Overview</a>
            <a href="mdepartment.php"><i class="fas fa-building"></i>&nbsp;Department</a>
            <a href="mstaff.php"><i class="fas fa-users"></i>&nbsp; Staff</a>
            <a href="mmessage.php" class="active"><i class="fas fa-bell"></i>&nbsp;Notifications</a>
            <a href="mearn.php"><i class="fas fa-money-bill"></i>&nbsp;Earn</a>
            <a href="mannouncements.php"><i class="fas fa-envelope"></i>&nbsp;Announcements</a>
            <a href="index.php"><i class="fas fa-sign-out-alt"></i>&nbsp;Log out</a>

            <div class="help-center">
                <button>
                    <i class="fas fa-question-circle"></i>
                    Help Center
                    <span>Having trouble?</span>
                </button>
            </div>
        </nav>

    </aside>
    <div class="main-content">
        <header class="main-header">
            <div class="greeting">
                <h1>Notifications</h1>
                <p></p>
            </div>
            <div class="search-and-user">
                <div class="search-container">
                    <i class="search-icon">🔍</i>
                    <input type="text" placeholder="Search">
                </div>
                <div class="notification-container">
                    <i class="notification-icon fas fa-bell"></i> 
                </div>
               
            </div>
        </header>
        <div class="messaging-container">
            <aside class="contact-list">
                <div class="search-bar">
                    <input type="text" placeholder="Search">
                    <button class="search-button"><i class="fas fa-search"></i></button>
                </div>
                <div class="chat-tabs">
                    <button class="tab">Saved</button>
                    <button class="tab">All chats</button>
                </div>
                <div class="contact" data-doctor-id="doctor1">
                    <img src="assets/dr1.webp" alt="Dr. Lionel Messie">
                    <div class="contact-info">
                        <h5>Dr. Lionel Messie</h5>
                        <p>House, my patient needs a new kidney!</p>
                    </div>
                    <span class="contact-time">15:30</span>
                </div>
                <div class="contact" data-doctor-id="doctor2">
                    <img src="assets/dr1.webp" alt="Dr. Lionel Messie">
                    <div class="contact-info">
                        <h5>Dr. Lionel Messie</h5>
                        <p>House, my patient needs a new kidney!</p>
                    </div>
                    <span class="contact-time">15:30</span>
                </div><div class="contact" data-doctor-id="doctor3">
                    <img src="assets/dr1.webp" alt="Dr. Lionel Messie">
                    <div class="contact-info">
                        <h5>Dr. Lionel Messie</h5>
                        <p>House, my patient needs a new kidney!</p>
                    </div>
                    <span class="contact-time">15:30</span>
                </div>
            </aside>
            
            <section class="chat-area">
                <header class="chat-header">
                    <img src="assets/dr1.webp" alt="Dr. Lionel Messie" class="chat-avatar">
                    <div class="chat-info">
                        <h4>Dr. Lionel Messie</h4>
                        <p>Online</p>
                    </div>
                    <div class="chat-options">
                        <i class="fas fa-ellipsis-h"></i>
                    </div>
                </header>
                <div class="chat-messages">
                    <div class="message sent">
                        <p>Thanks for your help!</p>
                        <span class="message-time">16:30</span>
                    </div>
                    <div class="message received">
                        <p>House, my patient needs a new kidney! If you can help or arrange it will be an honor for us.</p>
                        <span class="message-time">15:30</span>
                    </div>
                </div>
                
            </section>
            
        </div>



    <script>
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

    </script>   
</body>
</html>