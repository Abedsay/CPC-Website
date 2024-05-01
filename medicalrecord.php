<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add to Medical Record</title>
  <style>
body {
  font-family: Arial, sans-serif;
  background-color: #f0f2f5; /* Light background color */
}

.container {
  width: 450px; /* Adjust width as needed */
  margin: 50px auto;
  border-radius: 5px; /* Rounded corners */
  background-color: #fff; /* White background for form */
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Subtle shadow */
  padding: 30px;
}

h1 {
  text-align: center;
  margin-bottom: 20px;
  color: #31aae1; /* Green heading color */
  font-size: 24px; /* Larger heading */
}

.subheading {
  margin-top: 20px;
  margin-bottom: 10px;
  color: #333; /* Text color for subheadings */
  font-size: 18px; /* Smaller heading for sections */
}

.form-group {
  margin-bottom: 15px;
  display: flex; /* Arrange labels and inputs horizontally */
  align-items: center; /* Align vertically */
}

label {
  flex: 0 0 120px; /* Fix label width */
  margin-right: 10px; /* Spacing between label and input */
  color: #333; /* Text color for labels */
}

input[type="text"],
input[type="email"],
input[type="tel"],
input[type="password"],
textarea {
  flex: 1; /* Remaining width for input field */
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
  font-size: 16px; /* Adjust input font size */
}

textarea {
  height: 80px; /* Adjust textarea height */
}

button[type="submit"] {
  background-color: #31aae1; /* Green button color */
  border: none;
  color: white;
  padding: 12px 20px; /* Increase button padding */
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin-top: 10px;
  cursor: pointer;
  border-radius: 4px;
}

button[type="submit"]:hover {
  background-color: #238ab7; /* Darker green on hover */
}
    
  </style>
</head>
<body>
  <div class="container">
  <h1>Medical Record</h1>
  <form id="medicalrecord-form" action="medicalrecord.php" method="post">
    <div class="form-group">
      <label for="patient">Patient ID:</label>
      <input type="text" name="patient" id="patient" value="<?= isset($_GET['patientID']) ? htmlspecialchars($_GET['patientID']) : '' ?>" required>
    </div>
    <h2>Medical History</h2>
    <div class="form-group">
      <label for="allergies">Allergies (if any):</label>
      <textarea name="allergies" id="allergies" rows="2"></textarea>
    </div>
    <div class="form-group">
      <label for="pastmed">Past Medical Conditions (if any):</label>
      <textarea name="pastmed" id="pastmed" rows="2"></textarea>
    </div>
    <div class="form-group">
      <label for="currentmed">Current Medications (if any):</label>
      <textarea name="currentmed" id="currentmed" rows="2"></textarea>
    </div>
    <h2>Examination Findings</h2>
    <div class="form-group">
      <label for="findings">Findings:</label>
      <textarea name="findings" id="findings" rows="4" required></textarea>
    </div>
    <div class="form-group">
      <label for="diagnosis">Diagnosis:</label>
      <input type="text" name="diagnosis" id="diagnosis" required>
    </div>
    <h2>Treatment Plan</h2>
    <div class="form-group">
      <label for="treatment">Treatment Plan:</label>
      <textarea name="treatment" id="treatment" rows="4" required></textarea>
    </div>
    <button type="submit">Generate Record</button>
  </form>
  </div>
</body>
</html>
<?php
$servername = "localhost";
$username = "root"; 
$password = ""; 
$database = "clinic";

$conn = new mysqli($servername, $username, $password, $database, "3308");

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
function generateUniqueMedicalRecordID($conn) {
  $sql = "SELECT MAX(recordid) AS max_id FROM medicalrecord";
  $result = mysqli_query($conn, $sql);
  if (!$result) {
    die("Error getting max ID: " . mysqli_error($conn));
  }
  $row = mysqli_fetch_assoc($result);
  $max_id = intval($row['max_id']);
  $new_id = str_pad($max_id + 1, 6, "0", STR_PAD_LEFT);
  return $new_id;
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $id = $_POST['patient'];
  $allergies = $_POST['allergies']; 
  $pastmed = $_POST['pastmed'];  
  $currentmed = $_POST['currentmed'];
  $findings = $_POST['findings'];
  $diagnosis = $_POST['diagnosis'];
  $treatment = $_POST['treatment'];
  $recordid= generateUniqueMedicalRecordID($conn);
  if ($allergies==='') {
    $allergies='None';
  }
  if ($pastmed==='') {
    $pastmed='None';
  }
  if ($currentmed==='') {
    $currentmed='None';
  }

  $sql = "INSERT INTO medicalrecord VALUES ('$recordid', '$id', ' $allergies', '$pastmed', '$currentmed', '$findings', '$diagnosis', '$treatment',1)";
  if ($conn->query($sql) === TRUE) {
    header("Location: dpatientrecords.php");
  } else {
    echo "Error creating medical record: " . $conn->error;
  }
}

$conn->close();
?>