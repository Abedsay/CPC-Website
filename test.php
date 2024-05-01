<?php
session_start();
/*if (isset($_GET['doctor_id']) && !empty($_GET['doctor_id'])) {
    $doctor_id = intval($_GET['doctor_id']);
    $_SESSION['doctor_id'] = $doctor_id; // Storing the doctor_id in session to use later
} else {
    // Handle the case where 'doctor_id' is not set or is empty
    die("Doctor ID not provided.");
}*/
$doctor_id=1100;
$servername = "localhost";
$username = "root"; 
$password = ""; 
$database = "clinic";
$conn = new mysqli($servername, $username, $password, $database, "3308");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$dailySchedule = getDailySchedule($doctor_id, $conn);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['daily_schedule_id'])) {
    $_SESSION['daily_schedule_id'] = $_POST['daily_schedule_id'];
    header('Location: pa.php');
    exit();
}
function getDailySchedule($doctor_id, $conn) {
    $dailySchedule = [];
    $stmt = $conn->prepare("
        SELECT ds.*, a.reasonforvisit, p.name as patient_name
        FROM daily_schedule ds
        LEFT JOIN appointments a ON ds.appointment_id = a.appointmentid
        LEFT JOIN patient p ON a.id = p.id  
        WHERE ds.doctor_id = ? 
        ORDER BY ds.schedule_id, ds.start_time
    ");
    $stmt->bind_param("i", $doctor_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $dailySchedule[$row['schedule_id']][] = $row;
    }
    $stmt->close();
    return $dailySchedule;
}

function checkAppointment($appointments, $startTime) {
    foreach ($appointments as $appointment) {
        if ($appointment['start_time'] === $startTime && $appointment['status'] === 'booked') {
            return $appointment;
        }
    }
    return null;
}

function generateTimeSlotHtml($dailySchedule, $hour) {
    $timeSlotHtml = '';
    $formattedHour = str_pad($hour, 2, '0', STR_PAD_LEFT) . ":00:00";

    for ($dayOfWeek = 1; $dayOfWeek <= 5; $dayOfWeek++) {
        if ($hour == 12) {
            $timeSlotHtml .= "<td class='break'>Break</td>";
            continue;
        }

        $appointmentsForDay = $dailySchedule[$dayOfWeek] ?? [];
        $appointment = checkAppointment($appointmentsForDay, $formattedHour);

        if ($appointment) {
            $timeSlotHtml .= "<td class='booked1'><div class='appointment-details'></div></td>";
        } else {
            $scheduleId = isset($dailySchedule[$dayOfWeek]) ? $dailySchedule[$dayOfWeek][0]['daily_schedule_id'] : null;
            if($scheduleId) {
                $timeSlotHtml .= "<td class='available-slot'>
                                    <form method='post' action=''>
                                        <input type='hidden' name='daily_schedule_id' value='{$scheduleId}'>
                                        <input type='submit' class='appointment-card' value='                                          '>
                                    </form>
                                  </td>";
            } else {
                $timeSlotHtml .= "<td class='available-slot'><div class='appointment-card'></div></td>";
            }
        }
    }
    return $timeSlotHtml;
}
/*if (!isset($_SESSION['patient_id'])) {
    header("Location: thankyou.html"); // Replace with your login page URL
    exit();
  }*/
// Check if user is logged in and a patient
$patient_id = $_SESSION['patient_id'];

$sql_patient = "SELECT * FROM patient WHERE id='$patient_id'";
$result_patient = $conn->query($sql_patient);

if ($result_patient->num_rows == 1) {
  $patient_data = $result_patient->fetch_assoc();
  $name = $patient_data['name'];  // Extract patient name (replace with other desired data)
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HealthCare - Doctor's Weekly Calendar</title>
    <link rel="stylesheet" href="sc.Css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

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
            width: 250px;
            background: #010C80;
            padding: 20px;
            height: 100vh;
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

        .sidebar .help-center {
            position: absolute;
            bottom: 20px;
            width: calc(16% - 40px);
            /* Considering the padding of the sidebar */
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
            color:white;
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
        }
        
/* ... (rest of your CSS) ... */

/* The Modal (background) */
.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
    background-color: #fefefe;
    margin: 15% auto; /* 15% from the top and centered */
    padding: 20px;
    border: 1px solid #888;
    width: 80%; /* Could be more or less, depending on screen size */
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}

.booked1 .appointment-details {
    background-color: red; 
    padding: 20px;
    border-radius: 5px;
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
            <a href="website.php"><i class="fas fa-sign-out-alt"></i>&nbsp;Log out</a>
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
                <h1>Doctor's Weekly Calendar</h1>
                <p id="month-year">April 2024</p>
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
        <div id="calendar-container">
            <table id="calendar">
                <thead>
                    <tr>
                        <th>Time/Date</th>
                        <th>Monday</th>
                        <th>Tuesday</th>
                        <th>Wednesday</th>
                        <th>Thursday</th>
                        <th>Friday</th>
                    </tr>
                </thead>
                <tbody>
                    <?php for ($hour = 9; $hour <= 17; $hour++): ?>
                    <tr>
                        <td><?php echo str_pad($hour, 2, '0', STR_PAD_LEFT) . ":00"; ?></td>
                        <?php echo generateTimeSlotHtml($dailySchedule, $hour); ?>
                    </tr>
                <?php endfor; ?>
                </tbody>
                </tbody>
            </table>
        </div>
</div>
<div id="appointmentModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Edit Appointment</h2>
        <form id="appointmentForm">
            <label for="appointmentTime">Time:</label>
            <input type="time" id="appointmentTime" name="time">
            
            <label for="appointmentDetails">Details:</label>
            <input type="text" id="appointmentDetails" name="details">
            
            <input type="button" value="Save Changes" id="saveChanges">
            <input type="button" value="Delete Appointment" id="deleteAppointment">
        </form>
    </div>
</div>