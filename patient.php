<?php
session_start();
/*if (!isset($_SESSION['patient_id'])) {
    header("Location: thankyou.html"); // Replace with your login page URL
    exit();
  }*/
// Check if user is logged in and a patient
$patient_id = $_SESSION['patient_id'];
$servername = "localhost";
$username = "root"; 
$password = ""; 
$database = "clinic";
$conn = new mysqli($servername, $username, $password, $database, "3308");

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
if (isset($_POST['orderid'])) {
    $orderid = $_POST['orderid'];
    $sql_update = "UPDATE orderlabtest SET seenbytech = 1 WHERE orderid = ?";
    $stmt = $conn->prepare($sql_update);
    $stmt->bind_param("i", $orderid);
    $stmt->execute();
    $stmt->close();
}

if (isset($_POST['resultid'])) {
    $resultid = $_POST['resultid'];
    $sql_update = "UPDATE labtestresult SET seenbydr = 1 WHERE resultid = ?";
    $stmt = $conn->prepare($sql_update);
    $stmt->bind_param("i", $resultid);
    $stmt->execute();
    $stmt->close();
}

if (isset($_POST['preid'])) {
    $preid = $_POST['preid'];
    $sql_update = "UPDATE prescription SET seenbyphar = 1 WHERE preid = ?";
    $stmt = $conn->prepare($sql_update);
    $stmt->bind_param("i", $preid);
    $stmt->execute();
    $stmt->close();
}
$sql_patient = "SELECT * FROM patient WHERE id='$patient_id'";
$result_patient = $conn->query($sql_patient);

if ($result_patient->num_rows == 1) {
  $patient_data = $result_patient->fetch_assoc();
  $name = $patient_data['name'];  // Extract patient name (replace with other desired data)
}
$sql_orders = "SELECT orderlabtest.orderid
        FROM orderlabtest JOIN patient ON orderlabtest.id = patient.id
        WHERE orderlabtest.seenbypatient = 1 and patient.id = ?";
$sql_pre = "SELECT prescription.preid
FROM prescription JOIN patient ON prescription.id = patient.id
WHERE prescription.seenbypatient = 1 and patient.id = ?";
$sql_results = "SELECT labtestresult.resultid
FROM labtestresult JOIN patient ON labtestresult.id = patient.id
WHERE labtestresult.seenbypatient = 1 and patient.id = ?";
$sql_records = "SELECT medicalrecord.recordid
FROM medicalrecord JOIN patient ON medicalrecord.id = patient.id
WHERE medicalrecord.seenbypatient = 1 and patient.id = ?";


$stmt = $conn->prepare($sql_orders);
$stmt->bind_param("i", $patient_id);
$stmt->execute();
$result = $stmt->get_result();
$orders = [];
while($row = $result->fetch_assoc()) {
    $orders[] = $row;
}

$stmt2 = $conn->prepare($sql_pre);
$stmt2->bind_param("i", $patient_id);
$stmt2->execute();
$result2 = $stmt2->get_result();
$prescriptions = [];
while($row = $result2->fetch_assoc()) {
    $prescriptions[] = $row;
}


$stmt3 = $conn->prepare($sql_results);
$stmt3->bind_param("i", $patient_id);
$stmt3->execute();
$result3 = $stmt3->get_result();
$results = [];
while($row = $result3->fetch_assoc()) {
    $results[] = $row;
}

$stmt4 = $conn->prepare($sql_records);
$stmt4->bind_param("i", $patient_id);
$stmt4->execute();
$result4 = $stmt4->get_result();
$records = [];
while($row = $result4->fetch_assoc()) {
    $records[] = $row;
}
  
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HealthCare</title>

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

        .list-container {
            width: 100%;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            padding: 20px;
        }

        .record-entry {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px;
            border-bottom: 1px solid #eaeaea;
        }
        .record-name {
            padding: 10px;
        }
        .record-info {
            display: flex;
            align-items: center;
        }

        .record-details {
            display: flex;
            flex-direction: column;
        }
        .buttons-container {
            display: flex;
            align-items: center;
        }
        .button {
            text-align: center;
            padding: 8px 16px;
            margin: 0 4px;
            border: none;
            border-radius: 4px;
            font-size: 0.875rem;
            font-weight: bold;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .view-records {
            background-color: #007bff;
        }
        .submit-records {
            background-color: #28a745;
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
            <a href="pcalender.php"><i class="fas fa-calendar"></i>&nbsp;Calendar</a>
            <a href="pmessage.php"><i class="fas fa-bell"></i>&nbsp;Notifications</a>
            <a href="pannouncements.php"><i class="fas fa-envelope"></i>&nbsp;Announcements</a>
            <a href="patient.php" class="active"><i class="fas fa-clipboard-list"></i>&nbsp;Reports</a>
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
                <h1>Reports</h1>
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
        
        <div class="list-container">
            <h2 class="record-name">Medical Records</h2>
            <div class="list-container">
                <?php foreach ($records as $record): ?>
                <div class="record-entry">
                    <div class="record-info">
                        <div class="record-details">
                            <div class="record-id">Medical Record ID: <?= htmlspecialchars($record['recordid']) ?></div>
                        </div>
                    </div>
                    <div class="buttons-container">
                        <a href="viewmedicalrecord.php?recordid=<?= htmlspecialchars($record['recordid']) ?>">
                        <button class="button view-records">View Record</button></a>
                    </div>
                </div>
                <?php endforeach; ?>
           
            </div>

            <h2 class="record-name">Lab Test Orders</h2>
            <div class="list-container">
                <?php foreach ($orders as $order): ?>
                <div class="record-entry">
                    <div class="record-info">
                        <div class="record-details">
                            <div class="record-id">Order ID: <?= htmlspecialchars($order['orderid']) ?></div>
                        </div>
                    </div>
                    <div class="buttons-container">
                        <a href="viewlabtest.php?orderid=<?= htmlspecialchars($order['orderid']) ?>">
                        <button class="button view-records">View Record</button></a>
                        <form action="patient.php" method="post"><input type="hidden" name="orderid" value="<?= htmlspecialchars($order['orderid']) ?>"> <button class="button submit-records ">Submit Record</button></form>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php
                    if (isset($_POST['orderid'])) {
                        $orderid = $_POST['orderid'];
                        echo '<script>alert("Record submitted successfully!");</script>';
                        //header("Location: patient.php");
                    }
                ?> 
            </div>

            <h2 class="record-name">Prescription</h2>
            <div class="list-container">
                <?php foreach ($prescriptions as $prescription): ?>
                <div class="record-entry">
                    <div class="record-info">
                        <div class="record-details">
                            <div class="record-id">Prescription ID: <?= htmlspecialchars($prescription['preid']) ?></div>
                        </div>
                    </div>
                    <div class="buttons-container">
                        <a href="viewprescription.php?preid=<?= htmlspecialchars($prescription['preid']) ?>">
                        <button class="button view-records">View Record</button></a>
                        <form action="patient.php" method="post"><input type="hidden" name="preid" value="<?= htmlspecialchars($prescription['preid']) ?>"> 
                            <button class="button submit-records ">Submit Record</button>
                        </form>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php
                    if (isset($_POST['preid'])) {
                        $preid = $_POST['preid'];
                        echo '<script>alert("Record submitted successfully!");</script>';
                        //header("Location: patient.php");
                    }
                ?>
            </div>

            <h2 class="record-name">Lab Test Results</h2>
            <div class="list-container">
                <?php foreach ($results as $result): ?>
                <div class="record-entry">
                    <div class="record-info">
                        <div class="record-details">
                            <div class="record-id">Lab Test Result ID: <?= htmlspecialchars($result['resultid']) ?></div>
                        </div>
                    </div>
                    <div class="buttons-container">
                        <a href="viewlabtestresult.php?resultid=<?= htmlspecialchars($result['resultid']) ?>">
                        <button class="button view-records">View Record</button></a>
                        <form action="patient.php" method="post"><input type="hidden" name="resultid" value="<?= htmlspecialchars($result['resultid']) ?>"> <button class="button submit-records ">Submit Record</button></form>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php
                    if (isset($_POST['resultid'])) {
                        $resultid = $_POST['resultid'];
                        echo '<script>alert("Record submitted successfully!");</script>';
                        //header("Location: patient.php");
                    }
                ?>
            </div>  
        </div>
            
        
    </div>
</body>

</html> 