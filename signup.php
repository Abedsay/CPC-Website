<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $successful = true;
        if ($successful) {
            header("Location: patientinfo.php");
            exit;
        } else {
            echo "<h3>Registration Failed! Please try again.</h3>";
        }
    }
?>