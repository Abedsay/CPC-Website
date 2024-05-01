<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "clinic";
$port = "3308";

$conn = new mysqli($servername, $username, $password, $database, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action'])) {
        if ($_POST['action'] == 'fetch_doctors' && isset($_POST['clinic_id'])) {
            fetchDoctors($conn);
        } elseif ($_POST['action'] == 'fetch_schedule' && isset($_POST['doctor_id'])) {
            fetchSchedule($conn);
        } elseif ($_POST['action'] == 'delete_appointment') {
            $appointmentId = sanitizeInput($_POST['appointmentid']);
            deleteAppointment($conn, $appointmentId);
        }
        // New action to fetch patients
        elseif ($_POST['action'] == 'fetch_patients') {
            fetchPatients($conn);
        }elseif ($_POST['action'] == 'update_appointment') {
            $appointmentId = sanitizeInput($_POST['appointmentId']);
            $reason = sanitizeInput($_POST['reason']);
            updateAppointment($conn, $appointmentId, $reason);
        }

        // Update or Add new appointment
        
        // ... add more elseif for other actions
    }
}
$clinicOptions = '';
$sqlClinics = "SELECT clinic_id, clinic_name FROM clinic";
$resultClinics = $conn->query($sqlClinics);
while ($rowClinics = $resultClinics->fetch_assoc()) {
    $clinicOptions .= "<option value='".$rowClinics['clinic_id']."'>".$rowClinics['clinic_name']."</option>";
}


function fetchDoctors($conn) {
    $clinicId = $_POST['clinic_id'];
    $sql = "SELECT doctor_id, first_name, last_name FROM doctor WHERE clid = ?";
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        echo "Error preparing statement: " . htmlspecialchars($conn->error);
        exit;
    }
    
    $stmt->bind_param("i", $clinicId);
    $stmt->execute();
    $result = $stmt->get_result();

    if (!$result) {
        echo "Error executing query: " . htmlspecialchars($conn->error);
        exit;
    }

    $doctors = [];
    while ($row = $result->fetch_assoc()) {
        $row['name'] = $row['first_name'] . ' ' . $row['last_name'];
        $doctors[] = $row;
    }

    header('Content-Type: application/json');
    echo json_encode($doctors);
    exit();
}



function fetchSchedule($conn) {
    $doctorId = $_POST['doctor_id'];
    $sql = "SELECT ds.daily_schedule_id, ds.start_time, ds.end_time, ds.status, p.name AS patient_name, a.reasonforvisit, a.appointmentid, d.day_of_week
        FROM daily_schedule ds
        LEFT JOIN appointments a ON ds.daily_schedule_id = a.daily_schedule_id AND ds.doctor_id = a.drid
        LEFT JOIN patient p ON a.id = p.id
        INNER JOIN doctor_schedule d ON ds.schedule_id = d.schedule_id
        WHERE d.doctor_id = ?
        ORDER BY d.day_of_week, ds.start_time;";


    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo json_encode(['error' => "Error preparing statement: " . $conn->error]);
        exit();
    }

    $stmt->bind_param("i", $doctorId);
    if (!$stmt->execute()) {
        echo json_encode(['error' => "Error executing query: " . $stmt->error]);
        exit();
    }

    $result = $stmt->get_result();
    $schedules = [];
    while ($row = $result->fetch_assoc()) {
        $schedules[] = $row;
    }

    header('Content-Type: application/json');
    echo json_encode($schedules);
    exit();
}

function getPatientIdByName($conn, $patientName) {
    // Prepare a statement to select the patient ID based on the patient's name
    $stmt = $conn->prepare("SELECT id FROM patient WHERE name = ?");
    if ($stmt === false) {
        return null;
    }

    $stmt->bind_param("s", $patientName);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        return $row['id']; // return the patient ID
    }

    return null; // No patient found, or an error occurred
}
function fetchPatients($conn) {
    $sql = "SELECT id, name FROM patient";
    $result = $conn->query($sql);

    if (!$result) {
        echo "Error executing query: " . htmlspecialchars($conn->error);
        exit;
    }

    $patients = [];
    while ($row = $result->fetch_assoc()) {
        $patients[] = $row;
    }

    header('Content-Type: application/json');
    echo json_encode($patients);
    exit();
}

function updateAppointment($conn, $appointmentId, $reason) {
    $stmt = $conn->prepare("UPDATE appointments SET reasonforvisit = ? WHERE appointmentid = ?");
    if (!$stmt) {
        echo json_encode(['success' => false, 'error' => $conn->error]);
        return;
    }

    $stmt->bind_param("si", $reason, $appointmentId);
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
        exit();
    } else {
        echo json_encode(['success' => false, 'error' => $stmt->error]);
        exit();
    }

    $stmt->close();
}
function deleteAppointment($conn, $appointmentId) {
    // Start a transaction
    $conn->begin_transaction();

    try {
        // First, get the daily_schedule_id from the appointment to be deleted
        $stmt = $conn->prepare("SELECT daily_schedule_id FROM appointments WHERE appointmentid = ?");
        if (!$stmt) {
            throw new Exception($conn->error);
        }
        $stmt->bind_param("i", $appointmentId);
        if (!$stmt->execute()) {
            throw new Exception($stmt->error);
        }
        $result = $stmt->get_result();
        $scheduleId = null;
        if ($row = $result->fetch_assoc()) {
            $scheduleId = $row['daily_schedule_id'];
        }
        $stmt->close();

        if (is_null($scheduleId)) {
            throw new Exception("No daily schedule associated with this appointment.");
        }

        if (!is_numeric($appointmentId)) {
            echo json_encode(['success' => false, 'error' => 'Invalid appointment ID']);
            return; // stop execution if the appointment ID is not a valid integer
        }

        // Delete the appointment
        $stmt = $conn->prepare("DELETE FROM appointments WHERE appointmentid = ?");
        if (!$stmt) {
            throw new Exception($conn->error);
        }
        $stmt->bind_param("i", $appointmentId);
        if (!$stmt->execute()) {
            throw new Exception($stmt->error);
        }
        $stmt->close();

        // Update the daily_schedule to set the status to 'available'
        $stmt = $conn->prepare("UPDATE daily_schedule SET status = 'available', appointment_id = NULL WHERE daily_schedule_id = ?");
        if (!$stmt) {
            throw new Exception($conn->error);
        }
        $stmt->bind_param("i", $scheduleId);
        if (!$stmt->execute()) {
            throw new Exception($stmt->error);
        }
        $stmt->close();

        // Commit the transaction
        $conn->commit();
        echo json_encode(['success' => true]);
        exit();
    } catch (Exception $e) {
        // An error occurred, rollback the transaction
        $conn->rollback();
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        exit();
    }
}



$conn->close();
?>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CPC - Receptionist</title>
    <!-- Add this inside the <head> tag of your HTML -->

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
            position: relative;
            width: 250px;
            /* Adjust width as necessary */
            background-color: #fff;
            /* Adjust color as necessary */
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
            /* Add more styling for the header */
        }

        /* Styles for vitals and appointments to match the design */
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
            /* Add more styling for vitals cards */
        }

        .appointment {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
            padding: 20px;
            border-radius: 8px;
            background-color: #F8F8F8;
            /* Add more styling for appointment cards */
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

        /* Add this to your styles.css file */

        .sidebar {
            width: 250px;
            background: #f8f9fa;
            padding: 20px;
            height: 100vh;
            /* Adjust height as needed */
        }

        .sidebar .logo {
            text-align: center;
            padding-bottom: 15px;
            padding-top: 15px;
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
            color: #333;
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
            background-color: #0056b3;
            color: white;
        }

        .sidebar .navigation a i.icon {
            margin-right: 10px;
            /* You will need to add your own icons */
        }

        .sidebar .help-center {
            position: absolute;
            bottom: 20px;
            width: calc(14% - 40px);
            /* Considering the padding of the sidebar */
            text-align: center;
        }

        .sidebar .help-center button {
            background: #0056b3;
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

        /* Add this to your styles.css file */

        .main-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            background-color: #ecf0f1;
            /* Adjust to match your specific color */
        }

        .greeting h1,
        .greeting p {
            margin: 0;
        }

        .icon-button {
            background: none;
            border: none;
            font-size: 16px;
            /* Adjust to match your specific size */
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
            /* Adjust to match the design */
            height: 30px;
            /* Adjust to match the design */
            border-radius: 50%;
            margin-right: 10px;
        }

        /* Add more styling as needed for the fonts, colors, and other elements */
        /* Add this to your styles.css file */

        .main-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            background-color: #2c3e50;
            /* Adjust the color to match your design */
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
            /* Adjust the positioning and size of icons as needed */
        }

        .search-icon {
            left: 10px;
            /* Replace this text icon with an actual icon from an icon library */
        }

        .notification-icon {
            right: 10px;
            /* Replace this text icon with an actual icon from an icon library */
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
            /* Replace this text icon with an actual icon from an icon library */
        }


        /* Add more specific styles as needed */


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
        }

        .banner-content h1 {
            font-size: 1.5em;
            /* Adjust size as needed */
            margin: 0 0 10px 0;
        }

        .banner-content p {
            margin: 0;
        }

        .banner-image img {
            max-height: 100%;
            float: right;
            /* Adjust size as needed */
        }

        .vitals-section {
            background-color: #f9f9f9;
            /* Light grey background */
            padding: 20px;
            /* Adjust padding as needed */
            border-radius: 8px;
            /* Rounded corners for the section */

            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
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
            /* Adjust width as needed */
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
        }

        .status.upcoming {
            background-color: #2980b9;
        }

        .status.completed {
            background-color: #95a5a6;
        }

        .appointments-table img {
            width: 30px;
            /* Adjust size as needed */
            border-radius: 50%;
            margin-right: 10px;
        }

        @media (max-width: 768px) {

            .sidebar,
            .left-column,
            .right-column {
                width: 100%;
                /* Ensures that sidebar and content columns take full width */
                height: auto;
                /* Height auto for proper sizing */
            }

            .main-content,
            .dashboard-grid {
                margin-left: 0;
                padding-left: 0;
                /* Removes any margin or padding that pushes content to the side */
            }

            .dashboard-grid {
                display: block;
                /* Stacks the left and right columns */
            }

            .content-section {
                /* Ensure all content sections take full width and display one after another */
                display: block;
                width: 100%;
            }
        }

        @media (max-width: 1024px) {

            /* You might not need this if the above media query already handles up to 1024px width */
            .dashboard-grid {
                grid-template-columns: 1fr;
                /* Adjust if you are using a grid display */
            }

            .reports-section,
            .calendar-section,
            .content-section {
                margin-bottom: 20px;
                /* Ensures a margin at the bottom of sections */
            }

            /* Add more specific styles if needed */
        }


        .dashboard-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;

            /* Adjust the '300px' to fit the width of your sidebar */
            column-gap: 20px;
            /* Space between columns */
        }

        .right-column {
            /* This column will contain the reports and calendar */
            display: flex;
            flex-direction: column;
            height: fit-content;
        }

        .sidebar .navigation a.active {
            background-color: #0056b3;
            color: white;
        }

        .content-section {
            padding: 20px;
            background-color: #FFFFFF;
            border-radius: 8px;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.1);
            overflow-y: auto;
            height: 100vh;
            max-height: calc(100vh - 130px);
        }

        .content-section h2 {
            color: #2c3e50;
            /* Dark blue color matching the theme */
            margin-bottom: 10px;
            /* Space below the header */
            font-size: 1.25rem;
            /* Slightly larger font size */
            border-bottom: 2px solid #eaeaea;
            /* Light line for separation */
            padding-bottom: 5px;
            /* Space between text and line */
            width: 100%;
            /* Make sure it takes full width */
            box-sizing: border-box;
        }

        /* Styles for lists within content sections */
        .content-section ul {
            list-style: none;
            /* Remove default list styles */
            padding: 0;
            /* Remove default padding */
            margin: 0;
            /* Remove default margin */
        }

        .content-section ul li {
            background-color: #f8f9fa;
            /* Light grey background for each item */
            padding: 10px 15px;
            /* Padding inside list items */
            border-radius: 5px;
            /* Rounded corners for list items */
            margin-bottom: 8px;
            /* Space between list items */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.03);
            /* Very subtle shadow for depth */
            font-size: 0.9rem;
            /* Slightly reduced font size */
            color: #333;
            /* Dark grey color for text */
        }

        .content-section ul li:last-child {
            margin-bottom: 0;
            /* No margin for the last item */
        }

        /* Style for the notifications button */

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

        .download-button {
            display: inline-flex;
            /* Aligns the icon and text */
            align-items: center;
            /* Centers items vertically */
            justify-content: center;
            /* Centers items horizontally */
            margin-left: 15px;
            /* Adds space between the text and the button */
            padding: 8px 12px;
            /* Size of the button */
            background-color: #0056b3;
            /* Theme color for the button background */
            color: white;
            /* Text color */
            text-decoration: none;
            /* Removes underline from links */
            border-radius: 4px;
            /* Rounded corners */
            font-size: 0.8rem;
            /* Size of the text */
            transition: background-color 0.3s;
            /* Smooth transition for hover effect */
        }

        .button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-left: 10px;
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            font-size: 0.8rem;
            cursor: pointer;
            transition: background-color 0.3s;
            text-decoration: none;
            /* For anchor tag buttons */
        }

        /* Download button specific styles */


        /* Submit button specific styles */
        .submit-button {
            background-color: #28a745;
            /* Green color for submit action */
            color: white;
            /* Text color */
        }

        .button i {
            margin-right: 5px;
            /* Adds a small space between the icon and text */
        }

        .button:hover,
        .button:focus {
            opacity: 0.8;
            outline: none;
            /* Remove outline if focused */
        }

        #uploadForm label {
            display: block;
            /* Labels appear above inputs */
            margin-top: 10px;
            /* Space above each label */
            color: #333;
            /* Dark grey color for text */
        }

        /* Styles for form inputs */
        #uploadForm input[type="text"],
        #uploadForm input[type="file"] {
            width: 100%;
            /* Full width */
            padding: 10px;
            /* Comfortable padding inside inputs */
            margin-top: 5px;
            /* Space between label and input */
            margin-bottom: 10px;
            /* Space between inputs */
            border: 1px solid #ccc;
            /* Subtle border */
            border-radius: 4px;
            /* Rounded corners */
        }

        /* Styles for the form submit button */
        #uploadForm button {
            background-color: #28a745;
            /* Green color to indicate 'upload' action */
            color: white;
            /* Text color */
            padding: 10px 15px;
            /* Button size */
            border: none;
            /* No border */
            border-radius: 4px;
            /* Rounded corners */
            cursor: pointer;
            /* Cursor indicates button */
            margin-top: 10px;
            /* Space above the button */
            transition: background-color 0.3s;
            /* Transition for hover effect */
            border-radius: 15px;
        }

        #uploadForm button:hover {
            background-color: #218838;
            /* Darker green on hover */
        }

        /* Style for the lab test cards container */
        .lab-tests-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        /* Style for individual lab test cards */
        .lab-test-card {
            background-color: #f3f3f3;
            /* Light gray background similar to the appointments */
            padding: 20px;
            border-radius: 8px;
            /* Rounded corners */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            /* Slight shadow for depth */
            display: flex;
            justify-content: space-between;
            /* Space out the details and buttons */
            align-items: center;
            margin-bottom: 10px;
            /* Space between cards */
        }

        /* Style for lab test details */
        .lab-test-details {
            /* If you want to align items to start, you can uncomment the next line */
            /* align-items: flex-start; */
            flex-grow: 1;
            /* Allow details to fill space */
        }

        /* Style for the buttons group */
        .lab-test-buttons {
            display: flex;
            gap: 10px;
            /* Space between buttons */
        }

        /* Styling the buttons */
        .download-button {
            background-color: #0056b3;
            /* Blue background */
            color: white;
            /* White text */
            border: none;
            border-radius: 15px;
            /* Rounded corners */
            padding: 10px 15px;
            /* Padding inside buttons */
            cursor: pointer;
            /* Pointer cursor on hover */
            text-decoration: none;
            /* Remove underline from links if using <a> tags */
            font-size: 0.9em;
            transition: background-color 0.2s;
            /* Smooth color transition on hover */
        }

        .submit-button {
            background-color: #28a745;
            /* Blue background */
            color: white;
            /* White text */
            border: none;
            border-radius: 15px;
            /* Rounded corners */
            padding: 10px 15px;
            /* Padding inside buttons */
            cursor: pointer;
            /* Pointer cursor on hover */
            text-decoration: none;
            /* Remove underline from links if using <a> tags */
            font-size: 0.9em;
            transition: background-color 0.2s;
            /* Smooth color transition on hover */
        }

        /* Hover effect for buttons */
        .download-button:hover {
            background-color: #003d82;
            /* Slightly darker blue on hover */
        }

        .submit-button:hover {
            background-color: #218838;
            /* Slightly darker blue on hover */
        }

        /* Adjust the button styles if they are anchors */
        a.download-button,
        a.submit-button {
            display: inline-block;
            /* Allows padding and margin adjustments */
        }

        .otification-popup {
            max-height: 400px;
            overflow-y: auto;
            margin-bottom: 10px;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .messaging-container {
            display: flex;
            width: 100%;
            background-color: #F0F2F5;
            height: 99vh;
            max-height: calc(100vh - 130px);
            border-radius: 8px;
        }

        .contact-list {
            width: 25%;
            background: #fff;
            overflow-y: auto;
            border-right: 1px solid #ddd;
            border-top-left-radius: 8px;
            border-bottom-left-radius: 8px;
        }

        .chat-area {
            width: 75%;
            display: flex;
            flex-direction: column;
            border-top-right-radius: 8px;
            border-bottom-right-radius: 8px;
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

        /* More detailed styling and responsiveness */
        #messagesSection {
            padding: 0px;
            height: 99vh;
            max-height: calc(100vh - 130px);
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
            width: 100%;
            height: 60px;
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

        .medication-storage {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            padding: 20px;
        }

        .medication-card {
            background-color: #f3f3f3;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 10px;
            text-align: center;
        }

        .medication-image {
            max-width: 100%;
            height: auto;
            border-radius: 4px;
            margin-bottom: 10px;
            width: 150px;
            /* Adjust the width as needed */
            height: 200px;
            /* Adjust the height as needed */
            object-fit: contain;
        }

        .medication-name {
            font-size: 1rem;
            margin-bottom: 5px;
        }

        .quantity-adjuster {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .decrease-quantity,
        .increase-quantity {
            background-color: #eee;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
        }

        .quantity {
            margin: 0 10px;
        }

        #saveStorageButton {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 20px;
            display: block;
            width: 100%;
        }

        .storage-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        #viewStorage h2 {
            margin: 0;
            /* Adjust as necessary */
        }

        .medication-storage-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            /* Make sure it takes full width */
            box-sizing: border-box;
        }

        .save-button {
            background-color: #28a745;
            /* Blue background */
            color: white;
            /* White text */
            border: none;
            border-radius: 15px;
            /* Rounded corners */
            padding: 10px 15px;
            /* Padding inside buttons */
            cursor: pointer;
            /* Pointer cursor on hover */
            text-decoration: none;
            /* Remove underline from links if using <a> tags */
            font-size: 0.9em;
            transition: background-color 0.2s;
            /* Smooth color transition on hover */
        }

        /* Hover effect for buttons */
        .save-button:hover {
            background-color: #218838;
            /* Slightly darker blue on hover */
        }

        /* Adjust the button styles if they are anchors */
        a.save-button {
            display: inline-block;
            /* Allows padding and margin adjustments */
        }

        #calendar-container {
            max-width: 1200px;
            /* Increase max width for the calendar */
            margin: auto;
            background-color: #fff;
            /* Set calendar background color */
            border-radius: 10px;
            /* Add some rounded corners */
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            /* Add shadow */
            padding: 20px;
            position: relative;
            /* Ensure z-index works */
            z-index: 1;
            /* Ensure it's above the background */
        }

        header {
            text-align: center;
            margin-bottom: 20px;
        }

        h1 {
            color: #0084ff;
            /* Set header color */
            margin: 0;
        }

        h2 {
            color: #666;
            /* Set subheader color */
            margin: 5px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #E0E0E0;
            padding: 8px;
            text-align: center;
            background-color: #f9f9f9;
            /* Set cell background color */
            vertical-align: top;
            /* Align content to top */
        }

        th {
            background-color: #f2f2f2;
        }

        .time-label {
            background-color: #d3d3d3;
            /* Set time label background color */
            color: #333;
            /* Set time label text color */
        }

        .break-time {
            background-color: #f5f5f5;
            /* Set break time background color */
            font-style: italic;
            /* Italicize break time text */
            color: #777;
            /* Set break time text color */
        }

        .available {
    background-color: #C8E6C9; /* Light green */
}
.booked {
    background-color: #FFCDD2; /* Light red */
}
.unavailable {
    background-color: #BDBDBD; /* Light gray */
    color: #757575; /* Darker gray for text */
}


        .appointment-card {
            background-color: #f3f3f3;
            /* Default white background */
            border-radius: 4px;
            padding: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin: 4px;
            overflow: hidden;
        }
        .appointment-card.available {
    background-color: #4CAF50; /* Green background */
}

.appointment-card.booked {
    background-color: rgb(0, 83, 167);
    color: rgb(255, 255, 255);
}

.appointment-card.unavailable {
    background-color: #9E9E9E; /* Grey background */
}

        .break-time .appointment-card {
            background-color: rgba(247, 230, 230, 0.612);
            /* Different background for break times */
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
        tr:hover {
    background-color: #EEEEEE; /* Very light gray */
}
.patient_name {
    display: block;
    font-weight: bold;
}

.card {
  background-color: #010C80;
  color: white;
  border-radius: 8px;
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.1);
  padding: 20px;
  max-width: 400px;
  margin: 0 auto;
  display: none; /* Hidden by default */
  position: absolute; /* Positioned absolutely to the nearest positioned ancestor */
  z-index: 1000; /
}

/* Form Input Styles */
.input-group {
  margin-bottom: 15px;
  padding:20px;
}

.input-group label {
  display: block;
  margin-bottom: 5px;
}

.input-group input,
.input-group select {
  width: 100%;
  padding: 10px;
  border-radius: 4px;
  border: none;
  background-color: #F0F2F5;
}

/* Button Styles */
.button-container{
    text-align:center;
}
.btn {
  background-color: #4B91F1;
  color: white;
  padding: 10px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  margin: 0 5px;
  
}

.btn:hover {
  background-color: #366EB6;
}
.card-header {
    cursor: move; /* Indicates the element can be moved */
    background-color: #010C80; /* Dark background for the header */
    color: white; /* Text color */
    padding: 10px 15px; /* Some padding */
}
        /* Additional styling as needed for responsiveness and positioning */

        /* Add more detailed styling for calendar and fonts */

        /* Include FontAwesome CSS */
        @import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css');

        /* Add responsive design and more detailed styles as necessary */
    </style>
</head>


<body>
    <aside class="sidebar">
        <div class="logo">
            <img src="assets/images/WhatsApp Image 2024-04-20 at 1.59.26 PM.jpeg" alt="HealthCare Logo">
        </div>
        <br>
        <nav class="navigation">
            <a href="#" onclick="showSection('viewSchedule', event);" class="active"><i
                    class="fas fa-calendar-alt"></i>&nbsp;Appointments</a>
            <a href="#" onclick="showSection('messagesSection', event);"><i class="fas fa-bell"></i>&nbsp;Notifications</a>
        </nav>
    </aside>


    <div class="main-content">
        <header class="main-header">
            <div class="greeting">
                <h1>Welcome, Receptionist!</h1>
                <p>Review and manage appointments easily.</p>
            </div>
            <div class="search-and-user">
                <div class="search-container">
                    <i class="search-icon">🔍</i>
                    <input type="text" placeholder="Search">
                </div>

            </div>
        </header>

        <div class="dashboard-grid">
            <div class="left-column">
                <div id="viewSchedule" class="content-section" style="display: block;">
                    <div class="selection-panel">
                        <select id="clinicSelect">
                            <option value="" selected disabled>Choose a clinic</option>
                            <?php echo $clinicOptions; ?>
                        </select>


                        <select id="doctorSelect">
                            <option value="" selected disabled>Choose a doctor</option>
                        </select>
                    </div>
                    <div id="calendar-container" class="calendar-container">

                        <table>
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
                                <tr>
                                    <td class="time-label">9:00</td>
                                    <td id="Monday-09:00" class="appointment-slot">
                                        <div class="appointment-card"></div>
                                    </td>
                                    <td id="Tuesday-09:00" class="appointment-slot">
                                        <div class="appointment-card"></div>
                                    </td>
                                    <td id="Wednesday-09:00" class="appointment-slot">
                                        <div class="appointment-card"></div>
                                    </td>
                                    <td id="Thursday-09:00" class="appointment-slot">
                                        <div class="appointment-card"></div>
                                    </td>
                                    <td id="Friday-09:00" class="appointment-slot">
                                        <div class="appointment-card"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="time-label">10:00</td>
                                    <td id="Monday-10:00" class="appointment-slot">
                                        <div class="appointment-card"></div>
                                    </td>
                                    <td id="Tuesday-10:00" class="appointment-slot">
                                        <div class="appointment-card"></div>
                                    </td>
                                    <td id="Wednesday-10:00" class="appointment-slot">
                                        <div class="appointment-card"></div>
                                    </td>
                                    <td id="Thursday-10:00" class="appointment-slot">
                                        <div class="appointment-card"></div>
                                    </td>
                                    <td id="Friday-10:00" class="appointment-slot">
                                        <div class="appointment-card"></div>
                                    </td>

                                </tr>
                                <tr>
                                    <td class="time-label">11:00</td>
                                    <td id="Monday-11:00" class="appointment-slot">
                                        <div class="appointment-card"></div>
                                    </td>
                                    <td id="Tuesday-11:00" class="appointment-slot">
                                        <div class="appointment-card"></div>
                                    </td>
                                    <td id="Wednesday-11:00" class="appointment-slot">
                                        <div class="appointment-card"></div>
                                    </td>
                                    <td id="Thursday-11:00" class="appointment-slot">
                                        <div class="appointment-card"></div>
                                    </td>
                                    <td id="Friday-11:00" class="appointment-slot">
                                        <div class="appointment-card"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="time-label">12:00</td>
                                    <td id="Monday-12:00" class="appointment-slot break-time">
                                        <div>Break</div>
                                    </td>
                                    <td id="Tuesday-12:00" class="appointment-slot break-time">
                                        <div>Break</div>
                                    </td>
                                    <td id="Wednesday-12:00" class="appointment-slot break-time">
                                        <div>Break</div>
                                    </td>
                                    <td id="Thursday-12:00" class="appointment-slot break-time">
                                        <div>Break</div>
                                    </td>
                                    <td id="Friday-12:00" class="appointment-slot break-time">
                                        <div>Break</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="time-label">13:00</td>
                                    <td id="Monday-13:00" class="appointment-slot">
                                        <div class="appointment-card"></div>
                                    </td>
                                    <td id="Tuesday-13:00" class="appointment-slot">
                                        <div class="appointment-card"></div>
                                    </td>
                                    <td id="Wednesday-13:00" class="appointment-slot">
                                        <div class="appointment-card"></div>
                                    </td>
                                    <td id="Thursday-13:00" class="appointment-slot">
                                        <div class="appointment-card"></div>
                                    </td>
                                    <td id="Friday-13:00" class="appointment-slot">
                                        <div class="appointment-card"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="time-label">14:00</td>
                                    <td id="Monday-14:00" class="appointment-slot">
                                        <div class="appointment-card"></div>
                                    </td>
                                    <td id="Tuesday-14:00" class="appointment-slot">
                                        <div class="appointment-card"></div>
                                    </td>
                                    <td id="Wednesday-14:00" class="appointment-slot">
                                        <div class="appointment-card"></div>
                                    </td>
                                    <td id="Thursday-14:00" class="appointment-slot">
                                        <div class="appointment-card"></div>
                                    </td>
                                    <td id="Friday-14:00" class="appointment-slot">
                                        <div class="appointment-card"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="time-label">15:00</td>
                                    <td id="Monday-15:00" class="appointment-slot">
                                        <div class="appointment-card"></div>
                                    </td>
                                    <td id="Tuesday-15:00" class="appointment-slot">
                                        <div class="appointment-card"></div>
                                    </td>
                                    <td id="Wednesday-15:00" class="appointment-slot">
                                        <div class="appointment-card"></div>
                                    </td>
                                    <td id="Thursday-15:00" class="appointment-slot">
                                        <div class="appointment-card"></div>
                                    </td>
                                    <td id="Friday-15:00" class="appointment-slot">
                                        <div class="appointment-card"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="time-label">16:00</td>
                                    <td id="Monday-16:00" class="appointment-slot">
                                        <div class="appointment-card"></div>
                                    </td>
                                    <td id="Tuesday-16:00" class="appointment-slot">
                                        <div class="appointment-card"></div>
                                    </td>
                                    <td id="Wednesday-16:00" class="appointment-slot">
                                        <div class="appointment-card"></div>
                                    </td>
                                    <td id="Thursday-16:00" class="appointment-slot">
                                        <div class="appointment-card"></div>
                                    </td>
                                    <td id="Friday-16:00" class="appointment-slot">
                                        <div class="appointment-card"></div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>


                <div id=" submitResults" class="content-section" style="display: none;">
                    <h2>Upload Lab Test Results</h2>
                    <form id="uploadForm">
                        <label for="patientName">Patient Name:</label>
                        <input type="text" id="patientName" name="patientName" placeholder="Enter patient name">

                        <label for="fileAttachment">Result File:</label>
                        <input type="file" id="fileAttachment" name="fileAttachment">

                        <button type="submit">
                            <i class="fas fa-upload"></i> Upload
                        </button>
                    </form>
                </div>


                <div id="messagesSection" class="content-section" style="display: none;">
                    <div class="messaging-container">
                        <aside class="contact-list">
                            <div class="search-bar">
                                <input type="text" placeholder="Search">
                                <button class="search-button"><i class="fas fa-search"></i></button>
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
                            </div>
                            <div class="contact" data-doctor-id="doctor3">
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
                                    <p>House, my patient needs a new kidney! If you can help or arrange it will be
                                        an
                                        honor for us.</p>
                                    <span class="message-time">15:30</span>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
            <div class="right-column">
                <!-- The new container for announcements -->
                <div id="announcementsSection" class="ontent-section">
                    <div id="notificationPopup" class="otification-popup">
                        <div class="announcement-content">
                            <div class="notification-item">
                                <div class="notification-time">10:30 AM</div>
                                <div class="notification-sender">Username1</div>
                                <div class="notification-comment">This is the first comment text for the
                                    notification.
                                </div>
                            </div>
                            <div class="notification-item">
                                <div class="notification-time">11:00 AM</div>
                                <div class="notification-sender">Username2</div>
                                <div class="notification-comment">This is the second comment text for the
                                    notification.
                                </div>
                            </div>
                            <div class="notification-item">
                                <div class="notification-time">11:30 AM</div>
                                <div class="notification-sender">Username3</div>
                                <div class="notification-comment">Another insightful comment can be placed here.
                                </div>
                            </div>
                            <div class="notification-item">
                                <div class="notification-time">12:00 PM</div>
                                <div class="notification-sender">Username4</div>
                                <div class="notification-comment">More comments to check the scroll functionality.
                                </div>
                            </div>
                            <div class="notification-item">
                                <div class="notification-time">12:00 PM</div>
                                <div class="notification-sender">Username4</div>
                                <div class="notification-comment">More comments to check the scroll functionality.
                                </div>
                            </div>
                        </div>
                        <!-- Add as many notification items as needed to test the scrolling -->

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
        <div class="card" style="display: none;">
            <div class="card-header">
            <h2>Update Appointment</h2>
            </div>
            <form id="appointmentForm">
                <div class="input-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required disabled>
                </div>
                <div class="input-group">
                <label for="reason">Reason:</label>
                <input type="text" id="reason" name="reason" required>
                </div>
                <div class="input-group">
  <label for="time">Time:</label>
  <select id="time" name="time">
    <option value="9:00 AM">9:00 AM</option>
    <option value="10:00 AM">10:00 AM</option>
    <option value="11:00 AM">11:00 AM</option>
    <option value="12:00 PM">12:00 PM</option> <!-- Changed AM to PM -->
    <option value="1:00 PM">13:00 PM</option>   <!-- Changed 13:00 PM to 1:00 PM -->
    <option value="2:00 PM">14:00 PM</option>   <!-- Changed 14:00 PM to 2:00 PM -->
    <option value="3:00 PM">15:00 PM</option>   <!-- Changed 15:00 PM to 3:00 PM -->
    <option value="4:00 PM">16:00 PM</option>   <!-- Changed 16:00 PM to 4:00 PM -->
  </select>
</div>

                <div class="button-container">
                    <button type="submit" id="saveBtn" class="btn">Save</button>
                    <button type="button" id="deleteBtn" class="btn">Delete</button>
                </div>
            </form>
        </div>
    </div>
</body>

<script>
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

    document.addEventListener('DOMContentLoaded', function () {
        var clinicSelect = document.getElementById('clinicSelect');
        var doctorSelect = document.getElementById('doctorSelect');

        clinicSelect.addEventListener('change', function () {
            var clinicId = this.value;
            fetch('recep.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'action=fetch_doctors&clinic_id=' + clinicId
            })
                .then(response => response.json())
                .then(doctors => {
                    updateDoctorDropdown(doctors);
                })
                .catch(error => console.error('Error:', error));
        });

        doctorSelect.addEventListener('change', function () {
            var doctorId = this.value;
            fetch('recep.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'action=fetch_schedule&doctor_id=' + doctorId
            })
                .then(response => response.json())
                .then(schedules => {
                    populateSchedule(schedules);
                })
                .catch(error => console.error('Error:', error));
        });
    });

    function populateSchedule(schedules) {
    document.querySelectorAll('.appointment-slot').forEach(slot => {
        slot.innerHTML = '<div class="appointment-card"></div>'; 
    });

    schedules.forEach(schedule => {
        console.log(schedule);
        let formattedTime = schedule.start_time.substring(0, 5); // e.g., "09:00"
        let dayOfWeek = schedule.day_of_week;
        let slotId = `${dayOfWeek}-${formattedTime}`;
        let slot = document.getElementById(slotId);

        if (slot) {
            let content = ''; 
            let statusClass = schedule.status === 'available' ? 'available' : (schedule.status === 'booked' ? 'booked' : 'unavailable');

            if (statusClass !== 'unavailable') {
                // Include the start time in the data attribute for both booked and available slots
                content = `<div class="appointment-card ${statusClass}" data-appointment-id="${schedule.appointmentid}" data-start-time="${formattedTime}" onclick="editAppointment(this, '${schedule.status}');">`;
                if (schedule.status === 'booked') {
                    content += `
                        <div class="patient_name">${schedule.patient_name}</div>
                        <div class="reasonforvisiting">${schedule.reasonforvisit}</div>
                    `;
                } else {
                    content += `${schedule.status}`;
                }
                content += '</div>';
            } else {
                content = `<div class="appointment-card ${statusClass}">${schedule.status}</div>`;
            }
            slot.innerHTML = content;
        }
    });
}
    function updateDoctorDropdown(doctors) {
        var doctorSelect = document.getElementById('doctorSelect');
        doctorSelect.innerHTML = '<option value="" selected disabled>Choose a doctor</option>'; // Reset dropdown

        doctors.forEach(function (doctor) {
            var option = document.createElement('option');
            option.value = doctor.doctor_id;
            option.textContent = doctor.first_name + " " + doctor.last_name; // Concatenate first name and last name
            doctorSelect.appendChild(option);
        });
    }

    function editAppointment(element, status) {
        console.log("Appointment ID from element:", element.dataset.appointmentId);

    // Open the modal
    var modal = document.querySelector('.card');
    modal.dataset.appointmentId = element.dataset.appointmentId;

    console.log("Appointment ID set to modal:", modal.dataset.appointmentId);
    

    // If this is a booked appointment, fill in the modal fields
    if (status === 'booked') {
        document.getElementById('name').value = element.querySelector('.patient_name').innerText;
        document.getElementById('reason').value = element.querySelector('.reasonforvisiting').innerText;
        var modal = document.querySelector('.card');
        modal.dataset.appointmentId = element.dataset.appointmentId;
    } else {
        // Clear the form for a new appointment
        document.getElementById('appointmentForm').reset();
    }

    // Get the start time from the data attribute and set it in the form
    const startTime = element.dataset.startTime; // This retrieves the start time from the data attribute
    document.getElementById('time').value = convertTo12HrFormat(startTime);

    // Assuming 'modal' is the class of the modal to show
    var modal = document.querySelector('.card');
    modal.style.display = "block"; // Show the modal
    modal.style.position = "absolute"; // Ensure the modal can be positioned absolutely
    
    // Center the modal on the screen as a starting position
    modal.style.top = "50%";
    modal.style.left = "50%";
    modal.style.transform = "translate(-50%, -50%)";

    dragElement(modal); // Make the modal draggable
    }
    function convertTo12HrFormat(timeString) {
    let [hours, minutes] = timeString.split(':');
    hours = parseInt(hours, 10); // Convert to integer for accurate calculations

    // Set AM or PM
    const ampm = hours >= 12 ? 'PM' : 'AM';

    // Convert hours to 12-hour format
    hours = hours % 12;
    hours = hours || 12; // If 'hours' is 0, set to 12 (for 12:00 AM or PM)

    // If 'hours' is a single digit, prepend a '0' - based on your dropdown, you don't want to prepend a '0' here
    // hours = hours < 10 ? `0${hours}` : hours; // This line should be removed based on your dropdown values

    // Return the formatted time string
    return `${hours}:${minutes} ${ampm}`;
}
function closeModal() {
    var modal = document.querySelector('.card');
    modal.style.display = "none";
}

function refreshSchedule() {
    // Trigger a change event on the currently selected doctor to re-fetch and re-populate the schedule
    var event = new Event('change');
    document.getElementById('doctorSelect').dispatchEvent(event);
}

function updateAppointment(appointmentId, reason) {
    if(!confirm("Are you sure you want to save the updates?")) return;
    fetch('recep.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `action=update_appointment&appointmentId=${appointmentId}&reason=${reason}`
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            alert('Reason for visit updated successfully!');
            closeModal();
            refreshSchedule();
        } else {
            alert('Error updating reason: ' + result.error);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}
document.getElementById('saveBtn').addEventListener('click', function() {
    var appointmentId = document.querySelector('.card').dataset.appointmentId;
    var reason = document.getElementById('reason').value;

    // Update the appointment with the new reason
    updateAppointment(appointmentId, reason);
    refreshSchedule();
});


// Add event listener for deleting an appointment
document.getElementById("deleteBtn").addEventListener("click", function() {
    if(!confirm("Are you sure you want to delete this appointment?")) return;

    var modal = document.querySelector('.card');
    var appointmentId = modal.dataset.appointmentId; // Retrieve the appointment ID stored earlier

    console.log("Deleting appointment with ID:", appointmentId);
    fetch('recep.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `action=delete_appointment&appointmentid=${appointmentId}`
    })
    .then(response => response.json())
    .then(result => {
        if(result.success) {
            alert("Appointment deleted successfully!");
            closeModal();
            refreshSchedule();
        } else {
            alert("Error deleting appointment: " + result.error);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
});

function dragElement(elmnt) {
    var pos1 = 0, pos2 = 0, pos3 = 0, pos4 = 0;
    
    // Move the DIV from anywhere inside the DIV that has the card-header class
    if (elmnt.querySelector(".card-header")) {
        // if present, the header is where you move the DIV from:
        elmnt.querySelector(".card-header").onmousedown = dragMouseDown;
    } else {
        // otherwise, move the DIV from anywhere inside the DIV:
        elmnt.onmousedown = dragMouseDown;
    }

    function dragMouseDown(e) {
        e = e || window.event;
        e.preventDefault();
        // get the mouse cursor position at startup:
        pos3 = e.clientX;
        pos4 = e.clientY;
        document.onmouseup = closeDragElement;
        // call a function whenever the cursor moves:
        document.onmousemove = elementDrag;
    }

    function elementDrag(e) {
        e = e || window.event;
        e.preventDefault();
        // calculate the new cursor position:
        pos1 = pos3 - e.clientX;
        pos2 = pos4 - e.clientY;
        pos3 = e.clientX;
        pos4 = e.clientY;
        // set the element's new position:
        elmnt.style.top = (elmnt.offsetTop - pos2) + "px";
        elmnt.style.left = (elmnt.offsetLeft - pos1) + "px";
    }

    function closeDragElement() {
        // stop moving when mouse button is released:
        document.onmouseup = null;
        document.onmousemove = null;
    }
}







</script>

</html>