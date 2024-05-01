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
    <title>Appointments</title>

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

        .main-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            background-color: #ecf0f1;
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

            * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        .appointment-container {
            width: 100%;
            padding: 20px;
        }

        .appointment-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .search-bar {
            position: relative;
        }

        .search-bar input[type="search"] {
            padding: 10px;
            border-radius: 20px;
            border: 1px solid #ddd;
            padding-right: 40px;
        }

        .search-bar i {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
        }

        .user-profile {
            display: flex;
            align-items: center;
        }

        .user-profile img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .clinic-list {
            display: flex;
            gap:20px;
            flex-direction: column;
           
        }

        .clinic-card {
            display: flex;
            
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 10px;
        }

        .clinic-photo {
            margin-top: 10px;
            margin-right: 10px;
            width: 100px;
            height: 100px;
            border-radius: 10px;
            align-items: center;
            margin-bottom: 10px; 
            flex-shrink: 0;
         
        }

        .clinic-details {
            flex-grow: 1;
            
        }
        
        .clinic-details p, 
        .clinic-details h2, 
        .price-range {
            margin: 5px 0;
            font-size: 0.9em; 
        }


        .clinic-specialization, 
        .clinic-name, 
        .clinic-location, 
        .price-range {
                margin: 5px 0;
        }

        .clinic-specialization {
            color: #888;
            font-size: 0.9em;
        }

        .clinic-name {
            font-size: 1.1em;
            font-weight: bold;
        }

        .clinic-location {
            font-size: 0.9em;
            color: #888;
        }

        .price-range {
            font-size: 0.9em;
            color: #0056b3;
            font-weight: bold;
        }

        .check-availability {
            background-color: #010C80;
            color: white;
            border: none;
            border-radius: 15px;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 0.9em; 
            transition: background-color 0.2s ease-in-out;
            width: 120px; 
            text-align: center; /* Center-align the text within the button */
           margin-top:45px;
        }

        .check-availability:hover {
            background-color: #4B91F1;
        }

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
            <a href="poverview.php"><i class="fas fa-tachometer-alt"></i>&nbsp;Overview</a>
            <a href="pappointments.php" class="active"><i class="fas fa-calendar-alt"></i>&nbsp;Appointments</a>
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
                <h1>Appointments</h1>
            </div>
            <div class="search-and-user">
                <div class="search-container">
                    <i class="search-icon">🔍</i>
                    <input type="text" placeholder="Search">
                </div>
                <div class="notification-container">
                    <i class="notification-icon fas fa-bell"></i>
                </div>
                <div class="user-container">
                    <i class="user-icon fas fa-user"></i>
                    <span><?php echo htmlspecialchars($name); ?></span>
                </div>

            </div>
        </header>

        
        <div class="clinic-list">
            <!-- Public Health Clinic -->
            <div class="clinic-card">
                <img src="assets/dr1.webp" alt="Public Health Clinic" class="clinic-photo">
                <div class="clinic-details">
                    <p class="clinic-specialization">Public Health</p>
                    <h2 class="clinic-name">Public Health Clinic</h2>
                    <p>Comprehensive health assessments to monitor and maintain overall well-being.</p>
                    <p class="clinic-location">Dubai, UAE</p>
                </div>
                <a href="appointments1.php"><button class="check-availability">View Doctor</button></a>
            </div>

            <!-- Ent Clinic -->
            <div class="clinic-card">
                <img src="assets/dr1.webp" alt="ENT Clinic" class="clinic-photo">
                <div class="clinic-details">
                    <p class="clinic-specialization">Ear, Nose, Throat</p>
                    <h2 class="clinic-name">Ear, Nose, Throat Clinic</h2>
                    <p>Specialized care for ENT conditions including infections and allergies.</p>
                    <p class="clinic-location">Dubai, UAE</p>
                </div>
                <a href="appointments2.php"><button class="check-availability">View Doctor</button></a>
            </div>

            <!-- Dentistry Clinic -->
            <div class="clinic-card">
                <img src="assets/dr1.webp" alt="Dentistry Clinic" class="clinic-photo">
                <div class="clinic-details">
                    <p class="clinic-specialization">Dentistry</p>
                    <h2 class="clinic-name">Dentistry Clinic</h2>
                    <p>Expert dental services for maintaining oral health and hygiene.</p>
                    <p class="clinic-location">Dubai, UAE</p>
                </div>
                <a href="appointments3.php"><button class="check-availability">View Doctor</button></a>
            </div>

            <!-- Cardiology Clinic -->
            <div class="clinic-card">
                <img src="assets/dr1.webp" alt="Cardiology Clinic" class="clinic-photo">
                <div class="clinic-details">
                    <p class="clinic-specialization">Cardiology</p>
                    <h2 class="clinic-name">Cardiology Clinic</h2>
                    <p>Specialized care for heart-related conditions including heart diseases and hypertension.</p>
                    <p class="clinic-location">Dubai, UAE</p>
                </div>
                <a href="appointments4.php"><button class="check-availability">View Doctor</button></a>
            </div>
        
            <!-- Physical Therapy Clinic -->
            <div class="clinic-card">
                <img src="assets/dr1.webp" alt="Physical Therapy Clinic" class="clinic-photo">
                <div class="clinic-details">
                    <p class="clinic-specialization">Physical Therapy</p>
                    <h2 class="clinic-name">Physical Therapy Clinic</h2>
                    <p>Expert rehabilitation services to restore movement and function, alleviate pain, 
                        <br> and prevent disabilities through personalized treatment plans. </p>
                    <p class="clinic-location">Dubai, UAE</p>
                </div>
                <a href="appointments5.php"><button class="check-availability">View Doctor</button></a>
            </div>
            
        </div>
           
    </div>
</body>

</html> 