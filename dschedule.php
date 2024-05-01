<?php
session_start();
$servername= "localhost";
$usernamee = "root"; 
$password = ""; 
$database = "clinic"; 
$conn = new mysqli($servername, $usernamee, $password, $database, "3308");
$usernamee = "";
$doctor_id = $_SESSION['doctor_id'];
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql_doctor = "SELECT * FROM doctor join user on  user.id = doctor.doctor_id WHERE doctor.doctor_id ='$doctor_id'";
$result_doctor = $conn->query($sql_doctor);

if ($result_doctor->num_rows == 1) {
  $doctor_data = $result_doctor->fetch_assoc();
  $name = $doctor_data['name'];  // Extract doctor name
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
            $patientName = isset($appointment['patient_name']) ? htmlspecialchars($appointment['patient_name'], ENT_QUOTES, 'UTF-8') : "No Name Provided";
            $reasonForVisit = isset($appointment['reasonforvisit']) ? htmlspecialchars($appointment['reasonforvisit'], ENT_QUOTES, 'UTF-8') : "No Reason Provided";
            
            $timeSlotHtml .= "<td class='booked'><div class='appointment-details' style='background-color: #0053a7; color: white; padding: 5px; border-radius: 5px;'>
                                 <div class='patient-name'>{$patientName}</div>
                                 <div class='appointment-reason'>{$reasonForVisit}</div>
                               </div></td>";
        } else {
            if ($hour == 12) {
                $timeSlotHtml .= "<td class='break'>Break</td>";
            } else {
                $timeSlotHtml .= "<td></td>"; 
            }
        }
    }
    return $timeSlotHtml;
}
$dailySchedule = getDailySchedule($doctor_id, $conn);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>HealthCare - Doctor's Weekly Calendar</title>
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

        @import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css');
        .booked .appointment-details {
    background-color: #0053a7;
    color: white;
    padding: 5px;
    border-radius: 5px;
}

.break {
    background-color: #f0f0f0;
    text-align: center;
    vertical-align: middle;
}
body {
    font-family: Arial, sans-serif;
    background-color: #f5f5f5; /* Set background color */
    margin: 0;
    padding: 0;
}

#calendar-container {
    max-width: 1200px; /* Increase max width for the calendar */
    margin: auto;
    background-color: #fff; /* Set calendar background color */
    border-radius: 10px; /* Add some rounded corners */
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1); /* Add shadow */
    padding: 20px;
    position: relative; /* Ensure z-index works */
    z-index: 1; /* Ensure it's above the background */
}

header {
    text-align: center;
    margin-bottom: 20px;
}

h1 {
    color: #0084ff; /* Set header color */
    margin: 0;
}

h2 {
    color: #666; /* Set subheader color */
    margin: 5px 0;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: center;
    background-color: #f9f9f9; /* Set cell background color */
    vertical-align: top; /* Align content to top */
}

th {
    background-color: #f2f2f2;
}

.time-label {
    background-color: #d3d3d3; /* Set time label background color */
    color: #333; /* Set time label text color */
}

.break-time {
    background-color: #f5f5f5; /* Set break time background color */
    font-style: italic; /* Italicize break time text */
    color: #777; /* Set break time text color */
}

.closed {
    background-color: #ccc; 
}

.available {
    background-color: #e6f7ff; 
    color: #0084ff; 
}
.booked {
    background-color: #0053a7; 
    color: #333; 
}

.appointment-card {
    background-color: #ffffff; /* Default white background */
    border-radius: 4px;
    padding: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    margin: 4px;
    overflow: hidden;
}
.break-time .appointment-card {
    background-color: rgba(247, 230, 230, 0.612);/* Different background for break times */
    color: #777;
    font-style: italic;
}

.appointment-card:hover {
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    cursor: pointer;
}

.patient-name {
    display: block;
    font-weight: bold;
}

.appointment-reason {
    display: block;
    font-style: italic;
}
.not-available {
    background-color: #ffffff;
}
.booked .appointment-card {
    background-color: #0053a7; 
    color: #333; 
}
</style>
</head>
<body>
<aside class="sidebar">
    <div class="logo">
        <img src="images/healthcarelogo.jpg" alt="HealthCare Logo">
    </div>
    <br>
    <nav class="navigation">
            <a href="doverview.php"><i class="fas fa-tachometer-alt"></i>&nbsp;Overview</a>
            <a href="dschedule.php" class="active"><i class="fas fa-calendar-alt"></i>&nbsp;Schedule</a>
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
            <h1>Doctor's Weekly Calendar</h1>
            <p id="month-year">April 2024</p>
        </div>
        <div class="search-and-user">
            <div class="search-container">
                <i class="search-icon">🔍</i>
                <input type="text" placeholder="Search">
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
        </table>
    </div>
</div>

</body>
</html>