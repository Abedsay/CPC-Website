
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Medical Record</title>
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
    <h1>Medical Record</h1>
    <?php
  $servername = "localhost";
  $username = "root"; 
  $password = ""; 
  $database = "clinic";
  $conn = new mysqli($servername, $username, $password, $database, "3308");
  
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $recordid = isset($_GET["recordid"]) ? $_GET["recordid"] : null;

  // Check if labtestresultid is provided in the URL query string
  if ($recordid) {
    $sql = "SELECT * FROM medicalrecord WHERE recordid = '$recordid'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();

      echo "<h2>Patient ID: " . $row["id"] . "</h2>";
      echo "<h2>Medical History </h2><br>";
      echo "<b>Allergies (if any):</b> " . $row["allergies"] . "<br><br>";
      echo "<b>Past Medical Conditions (if any): </b>" . $row["pastmed"] . "<br><br>";
      echo "<b>Current Medications (if any):</b> " . $row["currentmed"] . "<br><br>";
      echo "<h2>Examination Findings: </h2><br>";
      echo "<b>Findings: </b>" . $row["findings"] . "<br><br>";
      echo "<b>Diagnosis: </b>" . $row["diagnosis"] . "<br><br>";
      echo "<h2>Treatment Plan </h2><br>";
      echo "<b>Treatment Plan: </b>" . $row["treatment"] . "<br><br>";

      // Add download button and functionality (optional)
      echo "<form action='download.php' method='post'>";
      echo "<input type='hidden' name='recordid' value='$recordid'>";
      echo "<button type='submit'>Download</button>";
      echo "</form>";
    } else {
      echo "No medical record found for ID: " . $recordid;
    }
  } else {
    echo "<p>Error: Missing recordid parameter.</p>";
  }

  $conn->close();
  ?>
  </div>
</body>
</html>