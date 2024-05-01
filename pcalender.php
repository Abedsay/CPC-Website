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
<title>HealthCare - patient's Weekly Calendar</title>
<link rel="stylesheet" href="sc.Css"> <!-- Assuming this contains specific styles for the calendar -->
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
            <a href="pappointments.php"><i class="fas fa-calendar-alt"></i>&nbsp;Appointments</a>
            <a href="pcalender.php" class="active"><i class="fas fa-calendar"></i>&nbsp;Calendar</a>
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
            <h1>Patient's Weekly Calendar</h1>
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
            </tbody>
        </table>
    </div>
    
<div id="appointmentModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Edit Appointment</h2>
        <form id="appointmentForm">
            <label for="appointmentTime">Time/Day:</label>
            <input type="time" id="appointmentTime" name="time">
            <label for="appointmentDetails">Details:</label>
            <input type="text" id="appointmentDetails" name="details">
            <input type="button" value="Save Changes" id="saveChanges">
            <input type="button" value="Delete Appointment" id="deleteAppointment">
        </form>
    </div>
</div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
  initializeCalendar();
});

function initializeCalendar() {
  window.appointments = [
    { day: 1, hour: 10, name: "John Doe", reason: "Checkup", id: 'appt1' },
    { day: 2, hour: 14, name: "Jane Smith", reason: "Dental Cleaning", id: 'appt2' },
    { day: 3, hour: 11, name: "Alice Johnson", reason: "Physical Examination", id: 'appt3' },
  ];
  drawAppointments();
}

function drawAppointments() {
  const tbody = document.querySelector('#calendar tbody');
  const clinicHours = { start: 9, end: 17 };
  
  tbody.innerHTML = '';

  for (let hour = clinicHours.start; hour <= clinicHours.end; hour++) {
    const row = document.createElement('tr');
    const timeCell = document.createElement('td');
    timeCell.textContent = `${hour}:00`;
    row.appendChild(timeCell);

    for (let day = 1; day <= 5; day++) {
      const cell = document.createElement('td');
      const appointment = window.appointments.find(a => a.day === day && a.hour === hour);
      if (appointment) {
        const appointmentDiv = document.createElement('div');
        appointmentDiv.textContent = `${appointment.name} - ${appointment.reason}`;
        appointmentDiv.dataset.appointmentId = appointment.id;
        appointmentDiv.classList.add('appointment-card', 'booked');
        cell.appendChild(appointmentDiv);
        appointmentDiv.addEventListener('click', function() {
          openModal(appointment.id);
        });
      } else {
        const emptySlotDiv = document.createElement('div');
        emptySlotDiv.classList.add('appointment-card');
        cell.appendChild(emptySlotDiv);
      }
      row.appendChild(cell);
    }
    tbody.appendChild(row);
  }
}

function openModal(appointmentId) {
  const modal = document.getElementById("appointmentModal");
  const appointment = window.appointments.find(a => a.id === appointmentId);
  if (appointment) {
    const timeInput = document.getElementById("appointmentTime");
    const detailsInput = document.getElementById("appointmentDetails");
    timeInput.value = `${appointment.hour}:00`;
    detailsInput.value = appointment.reason;
    modal.dataset.appointmentId = appointmentId;
    modal.style.display = "block";
  }
}

function closeModal() {
  const modal = document.getElementById("appointmentModal");
  modal.style.display = "none";
}

function updateAppointment() {
  const modal = document.getElementById("appointmentModal");
  const appointmentId = modal.dataset.appointmentId;
  const newTime = document.getElementById("appointmentTime").value;
  const newDetails = document.getElementById("appointmentDetails").value;
  
  // Update the appointment in the global appointments array
  const index = window.appointments.findIndex(a => a.id === appointmentId);
  if (index !== -1) {
    const newHour = parseInt(newTime.split(':')[0]);
    const newDay = parseInt(newTime.split(':')[1]); // Assume new time format is "hour:dayIndex"
    window.appointments[index].hour = newHour;
    window.appointments[index].day = newDay;
    window.appointments[index].reason = newDetails;
    
    // Redraw the appointments on the calendar
    drawAppointments();
  }
  
  closeModal();
}

function deleteAppointment() {
  const modal = document.getElementById("appointmentModal");
  const appointmentId = modal.dataset.appointmentId;
  
  // Remove the appointment from the global appointments array
  window.appointments = window.appointments.filter(a => a.id !== appointmentId);
  
  // Redraw the appointments on the calendar
  drawAppointments();
  
  closeModal();
}

function getAppointmentDetails(appointmentId) {
  const appointment = window.appointments.find(a => a.id === appointmentId);
  return appointment || { time: '10:00', details: 'Example appointment details' };
}

document.getElementById('saveChanges').addEventListener('click', updateAppointment);
document.getElementById('deleteAppointment').addEventListener('click', deleteAppointment);

var modal = document.getElementById("appointmentModal");
var closeButton = modal.querySelector(".close");

closeButton.onclick = function() {
  modal.style.display = "none";
}

window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}

</script>
</body>
</html>
