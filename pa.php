<?php
session_start();

if (!isset($_SESSION['daily_schedule_id'], $_SESSION['patient_id'])) {
    header("Location: booking.php"); // Adjust if necessary
    exit();
}

$patient_id = $_SESSION['patient_id'];
$daily_schedule_id = $_SESSION['daily_schedule_id'];
$doctor_id=1100;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $servername = "localhost";
  $username = "root"; 
  $password = ""; 
  $database = "clinic";
  $conn = new mysqli($servername, $username, $password, $database, "3308");
  
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

    $name = $conn->real_escape_string($_POST['name']);
    $gender = $conn->real_escape_string($_POST['gender']);
    $address = $conn->real_escape_string($_POST['Address']);
    $email = $conn->real_escape_string($_POST['email']);
    $pincode = $conn->real_escape_string($_POST['pincode']);
    $reason_for_visit = $conn->real_escape_string($_POST['reason_for_visit']);

    $stmt = $conn->prepare("INSERT INTO appointments (id, drid, date, time, status, reasonforvisit, daily_schedule_id) VALUES (?, ?, CURDATE(), CURTIME(), 'Scheduled', ?, ?)");
    $stmt->bind_param("iisi", $patient_id, $doctor_id, $reason_for_visit, $daily_schedule_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $appointment_id = $conn->insert_id;
        $update_schedule_stmt = $conn->prepare("UPDATE daily_schedule SET status = 'booked', appointment_id = ? WHERE daily_schedule_id = ?");
        $update_schedule_stmt->bind_param("ii", $appointment_id, $daily_schedule_id);
        $update_schedule_stmt->execute();
        $update_schedule_stmt->close();

        // Consider redirecting to a confirmation page instead of just outputting a message.
        header("Location: test.php?doctor_id=");
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Payment Form</title>
  <style>
    * {
    box-sizing: border-box;
}

hr {
    border: solid #47B5FF;
}

body {
    font-family:Verdana, Geneva, Tahoma, sans-serif;
    margin: 15px 25%;
    font-size: 15px;
    padding: 8px;
    background-color:#bebfcf;
    color:black ;
}

.container {
    /* background-image:#FF8787; */
    padding: 15px 50px 25px 50px;
    border: seashell;

    padding: 15px 50px 25px 50px;
    background-color:white;

    border: rgb(240, 238, 237);

    border-radius: 12px;
    width: fit-content;
    margin: auto;
    display: flex;
    opacity: 0.9;
}
span {
    color: #FF8787;
}

input[type="text"],
input[type="email"],
input[type="number"],
input[type="password"],
input[type="date"],
select,
textarea{
    background-color:white;
    width: 100%;
    padding: 13px;
    margin:10px;
    margin-left: 0px;
    border-radius: 5px;
    border-color: black;
}
fieldset{
    border: 2.5px solid black;
    border-radius: 5px;
}

.main_heading {
    text-align: center;
    font-size: 270%;
}

input[type="submit"]{
    background-color:#47B5FF;
    color:rgb(255, 255, 255);
    padding: 12px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    width: 100%;
}
input[type=submit]:hover{
    background-color:wheat;
    color: #c91e6e;
    font-weight: bolder;
    /* font-size: 120%; */
}
  </style>
</head>

<body>
  <div class="container">
    <form name="cardForm" action="pa.php" method="post">
      <hr />
      <h1 class="main_heading">Payment Form</h1>
      <p><span>*</span> <b>marked places are must to be filled</b></p>
      <hr />
      <h2>PERSONAL INFORMATION</h2>
      <p> Patient ID (hidden field for processing, not displayed to user): 
         <input type="hidden" name="patient_id" value="<?php echo $_SESSION['patient_id'] ?? ''; ?>" />
      </p>
      <p> NAME
        <span>*</span> :<input type="text" id="round" name="name" required
                        oninvalid="this.setCustomValidity('Enter your awesome full name here please')"
                        oninput="this.setCustomValidity('')"/></p>
                        value="<?php echo 'ID: ' . ($_SESSION['patient_id'] ?? ''); ?>" />
      <fieldset>
        <legend> CHOOSE GENDER<span>*</span></legend>
        <p>
          <input type="radio" name="gender" id="male" />
          <label for="male">Male</label>
          <input type="radio" name="gender" id="female" />
          <label for="female">Female</label>
         
        </p>
      </fieldset>
      <p> ADDDRESS<span>*</span> :
        <textarea name="Address" id="Address" cols="100" rows="8" required></textarea>
        <!-- adding a blank text area for writing adress-->
      </p>
      <p> Email<span>*</span> : <input type="email" name="email" id="email" required
                         oninvalid="this.setCustomValidity('Enter correct email address please')"
                         oninput="this.setCustomValidity('')"/></p>
      <p> PINCODE<span>*</span> <input type="number" name="pincode" id="pincode" pattern="[0-9]{4,}"/></p>

      <p>
        Reason for Visit<span>*</span>: <!-- Added this line -->
        <textarea name="reason_for_visit" id="reason_for_visit" cols="100" rows="8" required></textarea> <!-- Added this textarea -->
      </p>
      <hr />
      <h2><b>PAYMENT INFORMATION</b></h2>
      <p>
         Card Type<span>*</span>:-
        <select name="Card_type" id="Card_type" required>
          <option value="">--Select A Card Type--</option>
          <option value="Visa">Visa</option>
          <option value="Master Card">Master Card</option>
          <option value="RuPay">Rupay</option>
          <option value="Credit/Debit">Credit or Debit</option>
        </select>
      </p>
      <p>
        Card Number<span>*</span>:-
        <input type="number" name="card_number" id="card_number" required pattern="[0-9]{13,16}"
               oninvalid="this.setCustomValidity('Add correct card data here with correct length')"
               oninput="this.setCustomValidity('')"/>
      </p>
      <p>
        Card Expiry Date<span>*</span>:-
        <input type="date" name="Expiry_date" id="Expiry_date" required />
      </p>
      <p>
        CVV<span>*</span>:-
        <input type="password" name="CVV" id="CVV" maxlength="3" required pattern="[0-9]{3}"
               oninvalid="this.setCustomValidity('CVV needs to be 3 numbers long, no letters')"
               oninput="this.setCustomValidity('')"/>
      </p>
      <input class="btn" type="submit" value="SUBMIT DETAILS & PAY NOW" />
    </form>
  </div>
</body>

</html>