<?php
$servername= "localhost";
$usernamee = "root"; 
$password = ""; 
$database = "clinic"; 
$conn = new mysqli($servername, $usernamee, $password, $database, "3308");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
else {
    echo "Connected successfully<br>";
}

$usernamee = "";

if ($_SERVER["REQUEST_METHOD"]=="POST") {
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $user=$_POST['username'];
        $pass=$_POST['password'];

        //$sql = "SELECT * FROM user WHERE username='$user' and password='$pass'";
        //$result = $conn->query($sql);
        $stmt = $conn->prepare("SELECT * FROM user WHERE username=? AND password=?");
        $stmt->bind_param("ss", $user, $pass);
        $stmt->execute();
        $result = $stmt->get_result();
        //
        if ($result->num_rows > 0) {
            session_start();
            $row = $result->fetch_assoc();
            $_SESSION['username'] = $username;
            $type = $row['type'];
            $id =$row['id'];
            $name=$row['name'];
            if ($type === 'doctor') {
                $_SESSION['doctor_id'] = $id;  // Store patient ID in session
                $_SESSION['name'] = $name; 
                header("Location: doverview.php?doctor_id=" . $id);
                //header("Location: dcverview.php");
            }
            else if ($type === 'pharmacist') {
                header("Location: pharmacist.php");
            }
            else if ($type === 'labtechnician') {
                header("Location: labtech.php");
            }
            else if ($type === 'receptionist') {
                header("Location: recep.php");
            }
            else if ($type === 'manager') {
                header("Location: managerindex.php");
            }
            else if ($type === 'patient') {
               /* $sql2 = "SELECT * FROM patient WHERE id='$id'";
                $result2 = $conn->query($sql2);
                if ($result2->num_rows == 1) {
                    $row = $result->fetch_assoc();
                    $patient_id = $row['id'];  // Extract patient ID
                    $_SESSION['patient_id'] = $patient_id;  // Store patient ID in session
                    echo "<script>alert('Login successful! Redirecting to patient dashboard...');</script>";
                    // Redirect to patient dashboard with patient ID in the URL (replace with your actual patient dashboard page)
                    header("Location: patient.php?patient_id=" . $patient_id);
                  }
                //header("Location: patient.php");*/
                $_SESSION['patient_id'] = $id;  // Store patient ID in session
                header("Location: poverview.php?patient_id=" . $id);
            }
            else {
                $error = "Unexpected user type";
            }
            exit();
        }
        else {
            echo "<script>alert('Invalid username or password');</script>";
        }
        
    }
    else {
        echo "<script>alert('login data not received');</script>";
    }
}
else {
    echo "<script>alert('submission method not allowed');</script>";
}


$conn->close();
?>
<script>
  window.location.href = "register.php";
</script>