<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lab Test Results</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f0f2f5;/* Light blue background */
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
      color: #31aae1; 
      font-size: 24px; /* Larger heading */
    }

    .form-group {
      margin-bottom: 15px;
      display: flex; /* Arrange labels and inputs horizontally */
      align-items: center; /* Align vertically */
    }

    label {
      flex: 0 0 120px; /* Fix label width */
      margin-right: 10px; /* Spacing between label and input */
      color: #333; /* Adjust label color */
    }

    input[type="text"] {
      flex: 1; /* Remaining width for input field */
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 4px;
      box-sizing: border-box;
      font-size: 16px; /* Adjust input font size */
    }
    button[type="submit"] {
      background-color: #31aae1; 
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
      background-color: #238ab7; 
    }

  </style>
</head>
<body>
  <div class="container">
    <h1>Lab Test Results</h1>

    <form id="labresult-form" action="labtestresult.php" method="post">
    <div class="form-group">
    <label for="patient">Patient ID:</label>
    <input type="text" name="patient" id="patient" required>
    </div>
      <div class="form-group">
        <label for="testdate">Test Date:</label>
        <input type="date" name="testdate" id="testdate" required>
      </div>
      <h2>Test Results</h2>
      <div class="test-results">
        <div class="form-group">
          <label for="testname">Test Name:</label>
          <input type="text" name="testname" required>
        </div>
        <div class="form-group">
          <label for="result">Result:</label>
          <input type="text" name="result" required>
        </div>
        <div class="form-group">
          <label for="referencerange">Reference Range:</label>
          <input type="text" name="referencerange" required>
        </div>
        <div class="form-group">
          <label for="units">Units:</label>
          <input type="text" name="units" required>
        </div>
        <div class="form-group">
          <label for="flag">Flag:</label>
          <input type="text" name="flag">
        </div>
      </div>
      <br>
      <p><b>Notes:</b></p>
      <textarea rows="4" cols="50" name="notes" id="notes"></textarea>
      <br>
      <button type="submit">Submit Results</button>
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
function generateUniqueTestResultID($conn) {
  $sql = "SELECT MAX(resultid) AS max_id FROM labtestresult";
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
  $testdate = $_POST['testdate']; 
  $testname = $_POST['testname'];  
  $result = $_POST['result'];
  $referencerange = $_POST['referencerange'];
  $units = $_POST['units'];
  $flag = $_POST['flag'];
  $notes = $_POST['notes'];
  $resultid= generateUniqueTestResultID($conn) ;

  $sql = "INSERT INTO labtestresult VALUES ('$resultid', '$id', ' $testdate', '$testname', '$result', '$referencerange', '$units', '$flag','$notes',0,0)";
  if ($conn->query($sql) === TRUE) {
    header("Location: labtech.php");
    //echo "Lab Test Result created successfully!";
  } else {
    echo "Error creating lab test result: " . $conn->error;
  }
}
$patient_id = null;

if (isset($_GET["patient_id"])) {
  $patient_id = $_GET["patient_id"];
}
?>