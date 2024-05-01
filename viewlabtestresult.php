
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
    <?php
  $servername = "localhost";
  $username = "root"; 
  $password = ""; 
  $database = "clinic";
  $conn = new mysqli($servername, $username, $password, $database, "3308");
  
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  $id = isset($_GET["id"]) ? $_GET["id"] : null;
  //$labtestResultId = isset($_GET["resultid"]) ? $_GET["resultid"] : null;
  // Check if labtestresultid is provided in the URL query string
  if ($id) {
    $sql_lab = "SELECT * FROM patient join labtestresult on  patient.id = labtestresult.id WHERE patient.id ='$id'";
    $result_lab = $conn->query($sql_lab);

    if ($result_lab->num_rows >0) {
      $lab_data = $result_lab->fetch_assoc();
      $labtestResultId = $lab_data['resultid'];  // Extract doctor name
    
    
    $sql = "SELECT * FROM labtestresult WHERE resultid = '$labtestResultId'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();

      echo "<h2>Patient ID: " . $row["id"] . "</h2>";
      echo "<h2>Test Date: " . $row["testdate"] . "</h2>";
      echo "<b>Test Name: </b>" . $row["testname"] . "<br><br>";
      echo "<b>Result: </b>" . $row["result"] . "<br><br>";
      echo "<b>Reference Range: </b>" . $row["referencerange"] . "<br><br>";
      echo "<b>Units: </b>" . $row["units"] . "<br><br>";
      echo "<b>Flag: </b>" . ($row["flag"] ? $row["flag"] : "-") . "<br><br>"; // Display "-" if flag is empty
      echo "<p><b>Notes:</b><br>" . $row["notes"] . "</p>";

      // Add download button and functionality (optional)
      echo "<form action='download.php' method='post'>";
      echo "<input type='hidden' name='labtestresultid' value='$labtestResultId'>";
      echo "<button type='submit'>Download</button>";
      echo "</form>";
    } }else {
      echo "No test results found for ID: " . $id;
    }
  } else {
    echo "<p>Error: Missing labtestresultid parameter.</p>";
  }

  $conn->close();
  ?>
  </div>
</body>
</html>