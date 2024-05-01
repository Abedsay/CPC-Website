<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Order Lab Test</title>
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
    <h1>Lab Test Order</h1>
    <form id="labtest-form" action="labtest.php" method="post">
      <div class="form-group">
        <label for="patient">Patient ID:</label>
        <input type="text" name="patient" id="patient" value="<?= isset($_GET['patientID']) ? htmlspecialchars($_GET['patientID']) : '' ?>" required>
      </div>
      <div class="form-group">
        <label for="testtype">Test Type:</label>
        <input type="text" name="testtype" id="testtype" required>
      </div>
      <div class="form-group">
        <label for="reason">Reason for Test:</label>
        <textarea name="reason" id="reason" rows="4" required></textarea>
      </div>
      <button type="submit">Order Lab Test</button>
    </form>
  </div>
</body>
</html>
<?php
$servername= "localhost";
$usernamee = "root"; 
$password = ""; 
$database = "clinic"; 
$conn = new mysqli($servername, $usernamee, $password, $database, "3308");
$usernamee = "";
function generateUniqueLabTestID($conn) {
    $sql = "SELECT MAX(orderid) AS max_id FROM orderlabtest";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
      die("Error getting max ID: " . mysqli_error($conn));
    }
    $row = mysqli_fetch_assoc($result);
    $max_id = intval($row['max_id']);
    $new_id = str_pad($max_id + 1, 6, "0", STR_PAD_LEFT);
    return $new_id;
}

if ($_SERVER["REQUEST_METHOD"]=="POST") {
    $testtype=$_POST['testtype'];
    $reason=$_POST['reason'];
    $id = $_POST['patient'];
    $orderid= generateUniqueLabTestID($conn);
    $sql = "INSERT INTO orderlabtest VALUES('$orderid', '$id', '$testtype', '$reason',1,0)";
    if ($conn->query($sql) === TRUE) {
      header("Location: dpatientrecords.php");
      } else {
        echo "Error creating prescription: " . $conn->error;
      }
}
else {
    $error= "submission method not allowed";
}
$conn->close();
?>
