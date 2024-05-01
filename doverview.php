<?php
session_start();
$doctor_id = $_SESSION['doctor_id'];
$servername = "localhost";
$username = "root"; 
$password = ""; 
$database = "clinic";
$conn = new mysqli($servername, $username, $password, $database, "3308");

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$sql_doctor = "SELECT * FROM doctor join user on  user.id = doctor.doctor_id WHERE doctor.doctor_id ='$doctor_id'";
$result_doctor = $conn->query($sql_doctor);

if ($result_doctor->num_rows == 1) {
  $doctor_data = $result_doctor->fetch_assoc();
  $name = $doctor_data['name'];  // Extract patient name (replace with other desired data)
}
/*
$sql_doctor = "SELECT * FROM doctor WHERE doctor_id= ?";
$stmt = $conn->prepare($sql_doctor);
$stmt->bind_param("i", $doctor_id);
$stmt->execute();
$result_doctor = $stmt->get_result();

$stmt->close();*/
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Dashboard - HealthCare</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- Include additional CSS here if necessary -->
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        html {
            height: 100%;
            font-family: 'Arial', sans-serif;
            background: #F0F2F5;
        }


        body {
            display: flex;
            min-height: 100vh;
            font-family: 'Arial', sans-serif;
            background: #F0F2F5;
            margin: 0;
        }

        .sidebar {
            width: 250px;
            background-color: #fff;
            padding: 20px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
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
            position: fixed;
    width: 250px;
    background: #010C80;
    padding: 20px;
    height: 100vh;
    overflow-y: auto; 
    top: 0; 
    left: 0; 
    z-index: 100;
        }

        .sidebar .logo {
            text-align: center;
            padding-bottom: 20px;
        }

        .sidebar img {
            max-width: 100%;
            height: auto;
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
            width: 100%;
            height: 100%;
            border-radius: 10px;
        }

        .sidebar .navigation a.active,
        .sidebar .navigation a:hover {
            background-color: #4B91F1;
            color: white;
        }

        .sidebar .navigation a i.icon {
            margin-right: 10px;
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

        @media only screen and (max-width: 768px) {
            .sidebar {
                width: 100%; 
                padding: 10px;
            }

            .sidebar .logo img {
                max-width: 150px; 
            }

            .sidebar .navigation {
                flex-direction: column; 
            }

            .sidebar .navigation a {
                margin-bottom: 5px; 
            }

            .sidebar .help-center {
                display: none; 
            }

            .main-content {
                margin-left: 270px; 
                 padding: 20px;
    overflow: hidden;
            }

            .main-header {
                padding: 10px; 
            }

            .search-container {
                margin-right: 10px; 
            }

            .search-container input {
                padding: 8px; 
            }
        }

        @import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css');
        .welcome-banner {
    display: flex;
    align-items: center;
    padding: 20px;
    margin-bottom: 20px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
}

.doctor-image {
    width: 100px; 
    height: auto;
    margin-right: 20px;
    border-radius: 50%; 
}

.welcome-text h2 {
    margin: 0 0 10px 0;
    color: #0056b3;
}

.welcome-text p {
    margin: 0;
    color: #666;
}


.schedule-section {
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.1);
    margin-bottom: 20px;
    max-width: 800px;
}

.schedule-section h2 {
    color: #0056b3;
    margin-bottom: 15px;
}

.schedule-table {
    width: 100%;
    border-collapse: collapse;
}

.schedule-table th {
    text-align: left;
    padding: 8px;
    background-color: #f0f2f5;
    border-bottom: 1px solid #ddd;
}

.schedule-table td {
    padding: 8px;
    border-bottom: 1px solid #ddd;
}

.schedule-table tr:nth-child(even) {
    background-color: #f9f9f9;
}

.container-flex {
    display: flex;
    justify-content: space-between;
}

.schedule-section, 
.announcement-section {
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.1);
    margin-bottom: 20px;
    width: calc(50% - 10px); 
}

.toggle-suggest-btn {
            display: block;
            margin: 0 auto;
            background: none;
            border: none;
            color: #333;
            font-size: 24px;
            cursor: pointer;
        }

        .announcement-toggle-container {
            position: sticky;
            bottom: 0;
            background-color: #fff;
            padding: 10px;
            border-top: 1px solid #eee;
        }

        .toggle-suggest-btn i {
            color: #333;
        }

        .announcement-form {
            display: block;
            padding: 10px;
            border-top: 1px solid #eee;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.1);
        }

        @keyframes slideUp {
            from {
                transform: translateY(100%);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        #announcementText {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            resize: vertical;
        }

.announcement-form button {
            background-color: #5cb85c;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
        }

        .announcement-content {
            overflow-y: auto;
            padding: 10px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.1);
        }

        .otification-popup{
    max-height: 400px;
    overflow-y:auto;
    margin-bottom: 10px;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.1);
    border-radius: 8px;
}
.notifications-section {
            position: absolute;
            left: 57%;
            bottom: 10px;
            /* Adjust as needed */
            transform: translateX(-50%);
            width: 100%;
        }

        .notifications-section button {
            width: calc(100% - 40px);
            /* Account for padding */
            padding: 10px 20px;
            background-color: #0056b3;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        /* Style for the notifications popup */
        .notification-popup {
            display: block;
            /* Initially hidden */
            position: absolute;
            right: -410px;
            /* Width of sidebar plus some offset */
            width: 400px;
            max-height: 400px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            overflow-y: auto;
            z-index: 10;
            padding: 10px;
            background-color: #fff;
            border-radius: 4px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .notification-item {
            background-color: #f3f3f3;
            border-radius: 4px;
            padding: 10px;
            margin-bottom: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            list-style-type: none;
        }

        .notification-item:last-child {
            margin-bottom: 0;
        }

        .notification-time {
            color: #6c757d;
            font-size: 0.8em;
            margin-bottom: 4px;
        }

        .notification-sender {
            font-weight: bold;
            margin-bottom: 4px;
        }

        .notification-comment {
            font-size: 0.9em;
            /* Slightly smaller text for comments */
        }
        .announcement-form {
    position: sticky; /* Sticky position */
    bottom: 0; /* Stick to the bottom */
    z-index: 50; /* Adjust z-index as needed */
}
.main-content {
                margin-left: 270px; /* Adjust this value if the sidebar width changes */
    padding: 20px;
    overflow: hidden;
            }
            
            .sidebar .help-center {
    position: absolute;
    bottom: 20px;
    left: 20px; /* Align with the sidebar */
    right: 0; /* Align with the sidebar */
    padding: 0; /* Reset padding */
    text-align: center;
}

.sidebar .help-center button {
    background: #4B91F1;
    color: white;
    border: none;
    border-radius: 20px;
    padding: 10px 20px; /* Apply padding here */
    width: calc(100% - 25px); /* Adjust for specific padding */
    display: block;
}

.sidebar .help-center button i.icon {
    margin-right: 5px;
}

.sidebar .help-center button span {
    display: block;
    font-size: smaller;
}

        .schedule-section {
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.1);
    margin-bottom: 20px;
   width: 800px;
   height: max-content;
}
    </style>
</head>
<body>
    <aside class="sidebar">
        <div class="logo">
            <img src="assets/images/logo.jpg" alt="HealthCare Logo">
        </div>
        <nav class="navigation">
            <a href="doverview.php" class="active"><i class="fas fa-tachometer-alt"></i>&nbsp;Overview</a>
            <a href="dschedule.php" ><i class="fas fa-calendar-alt"></i>&nbsp;Schedule</a>
            <a href="dpatientrecords.php"><i class="fas fa-calendar"></i>&nbsp;Patient Records</a>
            <a href="dnotifications.php"><i class="fas fa-envelope"></i>&nbsp; Notifications</a>
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
                <h1>Welcome, Dr. <span><?php echo htmlspecialchars($name); ?></span></h1>
                <p>Here's what's on your schedule today.</p>
            </div>
            <div class="search-and-user">
                <div class="search-container">
                    <i class="search-icon">🔍</i>
                    <input type="text" placeholder="Search">
                </div>
            </div>
        </header>
        <div class="welcome-banner">
            <img src="images/doctor.png" alt="Doctor Image" class="doctor-image">
            <div class="welcome-text">
                <h2>Good Morning</h2>
                <p>Here's a quick overview of your day.</p>
            </div>
        </div>
      <div class="container-flex">
    <div class="schedule-section">
        <h2>Your Schedule for Today</h2>
        <table class="schedule-table">
            <tr>
                <th>Time</th>
                <th>Appointments</th>
            </tr>
            <tr>
                <td>08:00 AM</td>
                <td>Ahmad Abed Al-Rahman</td>
            </tr>
            <tr>
                <td>10:00 AM</td>
                <td>Mayan Al-Ashy</td>
            </tr>
            <tr>
                <td>01:00 PM</td>
                <td>Malak Amer</td>
            </tr>
        </table>
    </div>
    <div class="right-column">
        <div id="announcementsSection" class="ontent-section">
            <div id="notificationPopup" class="otification-popup">
                <div class="announcement-content">
                    <div class="notification-item">
                        <div class="notification-time">10:30 AM</div>
                        <div class="notification-sender">Username1</div>
                        <div class="notification-comment">This is the first comment text for the notification.</div>
                    </div>
                    <div class="notification-item">
                        <div class="notification-time">11:00 AM</div>
                        <div class="notification-sender">Username2</div>
                        <div class="notification-comment">This is the second comment text for the notification.</div>
                    </div>
                    <div class="notification-item">
                        <div class="notification-time">11:30 AM</div>
                        <div class="notification-sender">Username3</div>
                        <div class="notification-comment">Another insightful comment can be placed here.</div>
                    </div>
                    <div class="notification-item">
                        <div class="notification-time">12:00 PM</div>
                        <div class="notification-sender">Username4</div>
                        <div class="notification-comment">More comments to check the scroll functionality.</div>
                    </div>
                    <div class="notification-item">
                        <div class="notification-time">12:00 PM</div>
                        <div class="notification-sender">Username4</div>
                        <div class="notification-comment">More comments to check the scroll functionality.</div>
                    </div>
                </div>
                
            </div>
            <div class="announcement-form">
                <h3>Suggest an Announcement</h3>
                <form id="announcementForm">
                    <textarea id="announcementText" placeholder="Type your announcement..." rows="3"></textarea>
                    <button type="submit" onclick="submitAnnouncement(event)">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
</div>

    </div>
</body>
</html>
