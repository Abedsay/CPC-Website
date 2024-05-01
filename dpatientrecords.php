<?php
$servername = "localhost";
$username = "root"; 
$password = ""; 
$database = "clinic";
$conn = new mysqli($servername, $username, $password, $database, "3308");

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
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

$sql = "SELECT appointments.id, patient.name,patient.gender, appointments.reasonforvisit, patient.id
        FROM appointments 
        JOIN patient ON appointments.id = patient.id 
        WHERE appointments.drid = ?";
$stmt = $conn->prepare($sql);
//$doctor_id = 1100;
$stmt->bind_param("i", $doctor_id);
$stmt->execute();
$result = $stmt->get_result();
$patients = [];

while($row = $result->fetch_assoc()) {
    $patients[] = $row;
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>HealthCare</title>
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
        .list-container {
            width: 100%;
    margin: 0 auto;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    padding: 20px;
  }

  .patient-entry {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px;
    border-bottom: 1px solid #eaeaea;
  }

  .patient-info {
    display: flex;
    align-items: center;
  }

  .patient-info img {
    border-radius: 50%;
    margin-right: 16px;
    width: 50px; /* Adjust as needed */
    height: 50px; /* Adjust as needed */
  }

  .patient-details {
    display: flex;
    flex-direction: column;
  }

  .patient-name {
    font-size: 1rem;
    font-weight: bold;
  }

  .patient-gender, .patient-reason {
    font-size: 0.875rem;
    color: #666;
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

  .generate-records {
    background-color: #28a745;
  }

  .button:hover {
    filter: brightness(90%);
  }
        @import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css');

        
.list-container {
  margin: 20px auto;
  background-color: #fff;
}
.dropdown-menu {
    display: none; /* Hidden by default */
    position: absolute;
    background-color: #f9f9f9;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
}

.dropdown-item {
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
}

.dropdown-item:hover {
    background-color: #f1f1f1;
}

.buttons-container {
    position: relative;
}

</style>
</head>
<body>
    <aside class="sidebar">
        <div class="logo">
            <img src="assets/images/logo.jpg" alt="HealthCare Logo">
        </div>
        <nav class="navigation">
            <a href="doverview.php"><i class="fas fa-tachometer-alt"></i>&nbsp;Overview</a>
            <a href="dschedule.php" ><i class="fas fa-calendar-alt"></i>&nbsp;Schedule</a>
            <a href="dpatientrecords.php" class="active"><i class="fas fa-calendar"></i>&nbsp;Patient Records</a>
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
        <h1>List of Patients</h1>
        <p>View, Update, Generate and More!</p>
    </div>
    <div class="search-and-user">
        <div class="search-container">
            <i class="search-icon">🔍</i>
            <input type="text" placeholder="Search">
        </div>
    </div>
  </header>
  <div class="list-container">
  <div class="list-container">
    <?php foreach ($patients as $patient): $patientID=$patient['id']?>
    <div class="patient-entry">
        <div class="patient-info">
        <?php 
        $avatarPath = 'manAvatar.png'; 
        if (strtolower($patient['gender']) === 'female') {
            $avatarPath = 'images/womanAvatar.png';
        } elseif (strtolower($patient['gender']) === 'male') {
            $avatarPath = 'images/manAvatar.png';
        }
    ?>
            <img src="<?= $avatarPath ?>" alt="Patient Avatar">
            <div class="patient-details">
                <div class="patient-name"><?= htmlspecialchars($patient['name']) ?></div>
                <div class="patient-id">ID: <?= htmlspecialchars($patient['id']) ?></div>
                <div class="patient-reason">Reason for Visit: <?= htmlspecialchars($patient['reasonforvisit']) ?></div>
        </div></div>
        <div class="buttons-container">
            <a href="viewlabtestresult.php?id=<?= htmlspecialchars($patient['id']) ?>">
            <button class="button view-records">View Record</button></a>
            <button class="button generate-records">Generate Records</button>
            <div class="dropdown-menu" style="display:none;">
            <a href="prescription.php?patientID=<?php echo $patientID; ?>" class="dropdown-item">Prescription</a>
            <a href="medicalrecord.php?patientID=<?php echo $patientID; ?>" class="dropdown-item">Medical Record</a>
            <a href="labtest.php?patientID=<?php echo $patientID; ?>" class="dropdown-item">Lab Test Order</a>
        </div>
        </div>

    </div>
    <?php endforeach; ?>

    <div class="patient-entry">
        <div class="patient-info">
          <img src="images/manAvatar.png" alt="Patient Avatar">
          <div class="patient-details">
            <div class="patient-name">Adam Itani</div>
            <div class="patient-gender">ID: 5555</div>
            <div class="patient-reason">Reason for Visit: Consultation</div>
          </div>
        </div>
        <div class="buttons-container">
          <button class="button view-records">View Records</button>
          <button class="button generate-records">Generate Records</button>
          <div class="dropdown-menu" style="display:none;">
          <a href="prescription.php?patientID=<?php echo $patientID; ?>" class="dropdown-item">Prescription</a>
            <a href="medicalrecord.php?patientID=<?php echo $patientID; ?>" class="dropdown-item">Medical Record</a>
            <a href="labtest.php?patientID=<?php echo $patientID; ?>" class="dropdown-item">Lab Test Order</a>
        </div>
        </div>
    </div>
 
    <div class="patient-entry">
        <div class="patient-info">
        <img src="images/womanAvatar.png" alt="Patient Avatar">
        <div class="patient-details">
          <div class="patient-name">Nireez Al-Sweidan</div>
          <div class="patient-gender">ID: 3145</div>
          <div class="patient-reason">Reason for Visit: Checkup</div>
          
        </div>
      </div>
      <div class="buttons-container">
        <button class="button view-records">View Records</button>
        <button class="button generate-records">Generate Records</button>
        <div class="dropdown-menu" style="display:none;">
        <a href="prescription.php?patientID=<?php echo $patientID; ?>" class="dropdown-item">Prescription</a>
        <a href="medicalrecord.php?patientID=<?php echo $patientID; ?>" class="dropdown-item">Medical Record</a>
        <a href="labtest.php?patientID=<?php echo $patientID; ?>" class="dropdown-item">Lab Test Order</a>
        </div>
       </div> 
    </div>

    <div class="patient-entry">
        <div class="patient-info">
          <img src="images/Abdullah.png" alt="Patient Avatar">
          <div class="patient-details">
            <div class="patient-name">Abdullah Jrad</div>
            <div class="patient-gender">ID: 7691</div>
            <div class="patient-reason">Reason for Visit: Follow-up</div>
          </div>
        </div>
        <div class="buttons-container">
          <button class="button view-records">View Records</button>
          <button class="button generate-records">Generate Records</button>
          <div class="dropdown-menu" style="display:none;">
          <a href="prescription.php?patientID=<?php echo $patientID; ?>" class="dropdown-item">Prescription</a>
            <a href="medicalrecord.php?patientID=<?php echo $patientID; ?>" class="dropdown-item">Medical Record</a>
            <a href="labtest.php?patientID=<?php echo $patientID; ?>" class="dropdown-item">Lab Test Order</a>
        </div>
        </div> 
    </div>

</div>
</body>
<script>
document.querySelectorAll('.generate-records').forEach(button => {
    button.onclick = function() {
        let dropdown = this.nextElementSibling;
        dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
    }
});

window.onclick = function(event) {
    if (!event.target.matches('.generate-records')) {
        let dropdowns = document.getElementsByClassName("dropdown-menu");
        for (let i = 0; i < dropdowns.length; i++) {
            let openDropdown = dropdowns[i];
            if (openDropdown.style.display === 'block') {
                openDropdown.style.display = 'none';
            }
        }
    }
}</script>

</html>
