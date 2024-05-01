<?php
session_start();
$patient_id = $_SESSION['patient_id'];
$servername = "localhost";
$username = "root"; 
$password = ""; 
$database = "clinic";
$conn = new mysqli($servername, $username, $password, $database, "3308");

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql_patient = "SELECT * FROM patient WHERE id= ?";
$stmt = $conn->prepare($sql_patient);
$stmt->bind_param("i", $patient_id);
$stmt->execute();
$result_patient = $stmt->get_result();

$name = ''; 
if ($result_patient->num_rows == 1) {
    $patient_data = $result_patient->fetch_assoc();
    $name = $patient_data['name']; // Extract the patient's name
}

$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PatientOverview</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <!-- ... other head elements ... -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        /* Resetting default styles */
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

        .appointments-table .status.active {
            background-color: #5CBA47;
        }

        .appointments-table .status.upcoming {
            background-color: #2D9CDB;
        }

        .appointments-table .status.completed {
            background-color: #BDBDBD;
        }

        .sidebar {
            width: 300px;
            background: #010C80;
            padding: 20px;
            position:relative;
            
        }

        .sidebar .logo {
            text-align: center;
            padding-bottom: 20px;

        }

        .sidebar img {
             width:100%;
             height:100%;
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
            width: 60%;
            height: 60%;
            border-radius: 30px;
        }

        .sidebar .navigation a.active,
        .sidebar .navigation a:hover {
            background-color:  #4B91F1;
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

        .reports-section,
        .calendar-section {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin: 10px;
            padding: 20px;
            grid-row: 1 / span 2;
            /* Makes them stretch over two rows */
        }

        h2 {
            margin-bottom: 20px;
        }

        .report-item,
        .appointment {
            display: flex;
            align-items: center;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 8px;
            transition: background-color 0.3s;
        }

        .report-item:hover,
        .appointment:hover {
            background-color: #f4f4f4;
        }

        .report-info,
        .appointment-info {
            margin-left: 15px;
        }

        .fa-vial,
        .fa-chevron-right {
            color: #7f8c8d;
        }

        .date-highlight {
            background-color: #2c3e50;
            color: white;
            padding: 10px;
            border-radius: 8px;
        }

        .banner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px;
            background-color: #0056b3;
            color: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin:20px;
        }

        .banner-content h1 {
            font-size: 1.5em;
            margin: 0 0 10px 0;
        }

        .banner-content p {
            margin: 0;
        }

        .banner-image img {
            max-height: 100%;
            float: right;
        }

        .vitals-section {
            background-color: #f9f9f9;
            /* Light grey background */
            padding: 20px;
            border-radius: 8px;
            /* Rounded corners for the section */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin:20px;
        }

        .vitals-cards {
            display: flex;
            justify-content: space-between;
            /* Distributes space evenly */
            
        }

        .vital-card {
            background-color: #fff;
            /* White background for cards */
            padding: 10px 20px;
            /* Padding inside cards */
            border-radius: 8px;
            /* Rounded corners for cards */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            /* Subtle shadow for depth */
            width: 22%;
        }

        .vital-card h3 {
            margin: 0 0 10px 0;
            /* Spacing below headings */
            font-size: 0.9em;
            /* Smaller font size for headings */
        }

        .vital-card p {
            margin: 0;
            /* No margin for paragraph to keep things tight */
            font-weight: bold;
            /* Bold for the numbers */
            font-size: 1.2em;
            /* Larger font size for numbers */
        }

        .appointments-section {
            background-color: #f9f9f9;
            /* Light grey background */
            border-radius: 8px;
            /* Rounded corners for the section */
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin:20px;
        }

        .appointments-table {
            width: 100%;
            border-collapse: collapse;
        }

        .appointments-table thead th {
            background-color: #ecf0f1;
            color: #333;
            text-align: left;
            padding: 10px;
        }

        .appointments-table tbody td {
            padding: 10px;
            border-bottom: 1px solid #ecf0f1;
        }

        .status {
            padding: 5px 10px;
            border-radius: 10px;
            color: white;
            font-weight: bold;
            text-align: center;
            display: inline-block;
        }

        .status.active {
            background-color: #27ae60;
            width:100px;
        }

        .status.upcoming {
            background-color: #2980b9;
            width:100px;
        }

        .status.completed {
            background-color: #95a5a6;
            width:100px;
        }

        .appointments-table img {
            width: 30px;
            border-radius: 50%;
            margin-right: 10px;
        }

        @media (max-width: 768px) {
            body {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                height: auto;
            }

            .main-content {
                margin-left: 0;
            }
        }

        @media (max-width: 1024px) {
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
                padding: 10px; 
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
            .dashboard-grid {
                grid-template-columns: 1fr;
                /* Stack the grid items on smaller screens */
            }

            .reports-section,
            .calendar-section {
                margin-bottom: 20px;
                /* Allows them to flow naturally in the grid */
            }
        }

        .dashboard-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;;
            
            column-gap: 20px; /* Space between columns */
        }
        
        .right-column {
            /* This column will contain the reports and calendar */
            display: flex;
            flex-direction: column;
            height: fit-content;
        }

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
            /* Light background for each item */
            border-radius: 4px;
            /* Rounded corners for each item */
            padding: 10px;
            /* Padding inside each item */
            margin-bottom: 10px;
            /* Space between items */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            /* Subtle shadow for each item */
            list-style-type: none;
            /* Remove list bullets */
        }

        .notification-item:last-child {
            margin-bottom: 0;
            /* Remove margin for the last item */
        }

        .notification-time {
            color: #6c757d;
            /* Muted text color */
            font-size: 0.8em;
            /* Smaller text */
            margin-bottom: 4px;
            /* Space between time and username */
        }

        .notification-sender {
            font-weight: bold;
            /* Bold username */
            margin-bottom: 4px;
            /* Space between username and comment */
        }

        .notification-comment {
            font-size: 0.9em;
            /* Slightly smaller text for comments */
        }

        .toggle-suggest-btn {
            display: block;
            margin: 0 auto;
            /* Centers the button horizontally */
            background: none;
            border: none;
            color: #333;
            /* Color of the arrow, make sure it's visible on the background */
            font-size: 24px;
            /* Adjust the size of the arrow as needed */
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
            /* Or any color that would show up against the button background */
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
            /* Ensure the textarea spans the width of the popup */
            padding: 8px;
            margin-bottom: 10px;
            /* Space between textarea and button */
            border: 1px solid #ddd;
            border-radius: 4px;
            resize: vertical;
            /* Allow vertical resizing */
        }

        .announcement-form button {
            background-color: #5cb85c;
            /* A green submit button */
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
        /* More detailed styling and responsiveness */

        /* Include FontAwesome CSS */
        @import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css');

    </style>
</head>


<body>
    <aside class="sidebar">
        <div class="logo">
            <img src="assets/images/logo.jpg" alt="HealthCare Logo">
        </div>
        <br>
        <nav class="navigation">
            <a href="poverview.php" class="active"><i class="fas fa-tachometer-alt"></i>&nbsp;Overview</a>
            <a href="pappointments.php"><i class="fas fa-calendar-alt"></i>&nbsp;Appointments</a>
            <a href="pcalender.php"><i class="fas fa-calendar"></i>&nbsp;Calendar</a>
            <a href="pmessage.php"><i class="fas fa-bell"></i>&nbsp;Notifications</a>   
            <a href="pannouncements.php"><i class="fas fa-envelope"></i>&nbsp;Announcements</a>
            <a href="patient.php"><i class="fas fa-clipboard-list"></i>&nbsp;Reports</a>
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
                <h1>Welcome to Our Clinic!</h1>
                <p>How are you feeling today?</p>
            </div>
            <div class="search-and-user">
                <div class="search-container">
                    <i class="search-icon">🔍</i>
                    <input type="text" placeholder="Search">
                </div>
                
                <div class="user-container">
                    <i class="user-icon fas fa-user"></i>
                    <span><?php echo htmlspecialchars($name); ?></span>
                </div>

            </div>
        </header>

        <div class="dashboard-grid">

            <div class="left-column">
                <div class="banner">
                    <div class="banner-content">
                        <h1>Find the best doctors with Health Care</h1>
                        <p>Appoint the doctors and get finest medical services.</p>
                    </div>
                    <div class="banner-image">
                      
                        <img src="assets/Screenshot 2024-04-17 190340.png" alt="Health Care" />

                    </div>
                </div>

                <div class="vitals-section">
                    <h2>Vitals</h2>
                    <div class="vitals-cards">
                        <div class="vital-card">
                            <h3>Body Temperature</h3>
                            <p>36.2 °C</p>
                        </div>
                        <div class="vital-card">
                            <h3>Pulse</h3>
                            <p>85 bpm</p>
                        </div>
                        <div class="vital-card">
                            <h3>Blood Pressure</h3>
                            <p>80/70 mmHg</p>
                        </div>
                        <div class="vital-card">
                            <h3>Breathing Rate</h3>
                            <p>15 breaths/m</p>
                        </div>
                    </div>
                </div>

                <div class="appointments-section">
                    <h2>Appointments</h2>
                    <table class="appointments-table">
                        <thead>
                            <tr>
                                <th>Doctor</th>
                                <th>Specialization</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><img src="assets/dr1.webp" alt="James Carter"> James Carter</td>
                                <td>Cardiologist</td>
                                <td>2/11/23</td>
                                <td>45:00</td>
                                <td><span class="status active">Cancelled</span></td>
                            </tr>
                            <tr>
                                <td><img src="assets/dr1.webp" alt="James Carter"> James Carter</td>
                                <td>Cardiologist</td>
                                <td>2/11/23</td>
                                <td>45:00</td>
                                <td><span class="status upcoming">Upcoming</span></td>
                            </tr>
                            <tr>
                                <td><img src="assets/dr1.webp" alt="James Carter"> James Carter</td>
                                <td>Cardiologist</td>
                                <td>2/11/23</td>
                                <td>45:00</td>
                                <td><span class="status completed">Completed</span></td>
                            </tr>
                            <tr>
                                <td><img src="assets/dr1.webp" alt="James Carter"> James Carter</td>
                                <td>Cardiologist</td>
                                <td>2/11/23</td>
                                <td>45:00</td>
                                <td><span class="status completed">Completed</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="right-column">
                <div class="reports-section">
                    <h2>My Reports</h2>
                    <div class="report-item">
                        <b><a href="patient.php" style="text-decoration: none; color:black;">View my reports</a></b>              
                    </div>
                  
                </div>
                <div class="calendar-section">
                    <h2>Date</h2>
                    <div class="calendar">
                        <!-- Calendar structure -->
                    </div>
                    <div class="appointment">
                        <div class="date-highlight">
                            <span>Wed</span>
                            <strong>20</strong>
                        </div>
                        <div class="appointment-info">
                            <h3>Dr. Lionel</h3>
                            <p>Cardiologist - 12:30 pm</p>
                        </div>
                        <i class="fas fa-chevron-right"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
</body>

</html>