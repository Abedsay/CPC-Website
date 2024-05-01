<?php
$servername= "localhost";
$usernamee = "root"; 
$password = ""; 
$database = "clinic"; 
$conn = new mysqli($servername, $usernamee, $password, $database, "3308");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$usernamee = "";

function generateUniquePatientID($conn) {
    $sql = "SELECT MAX(id) AS max_id FROM patient";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
      die("Error getting max ID: " . mysqli_error($conn));
    }
    $row = mysqli_fetch_assoc($result);
    $max_id = intval($row['max_id']);
    $new_id = str_pad($max_id + 1, 6, "0", STR_PAD_LEFT);
    return $new_id;
}
function generateUniqueInsuranceID($conn) {
    $sql = "SELECT MAX(insuranceid) AS max_id FROM insurance";
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
    $name=$_POST['name'];
    $gender=$_POST['gender'];
    $dob=$_POST['dob'];
    $email=$_POST['email'];
    $phone=$_POST['phone'];
    $pass=$_POST['password'];
    $ins=$_POST['insurance'];
    if ($ins==='yes') {
        $insurance=1;
    }
    else {
        $insurance=0; 
    }
    $id = generateUniquePatientID($conn);
    $username = strtolower(str_replace(' ', '', $name)) . "@cpc.com";
    $sql = "INSERT INTO patient VALUES('$id', '$name','$gender','$dob','$email','$phone','$insurance')";
    if ($conn->query($sql) === TRUE) { 
        echo "New record created successfully"; 
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $sql2 = "INSERT INTO user VALUES('$id', '$name','$username','$pass','patient')";
    if ($conn->query($sql2) === TRUE) { 
        echo "New user created successfully"; 
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $itype=$_POST['insurance_type'];
    $pn=$_POST['policy_number'];
    $provider=$_POST['provider'];
    $eff=$_POST['effective_date'];
    $exp=$_POST['expiration_date'];
    $inid=generateUniqueInsuranceID($conn);
    $sql3 = "INSERT INTO insurance VALUES('$inid', '$id','$itype','$pn','$provider','$eff','$exp')";
    if ($conn->query($sql3) === TRUE) { 
        echo "New record created successfully"; 
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    header("Location: register.php");
}
else {
    echo "submission method not allowed";
}


$conn->close();
?>
