<?php
// get_staff.php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "clinic";
$port = "3308";

$conn = new mysqli($servername, $username, $password, $dbname, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
function deleteEmployee($id) {
    global $conn;
    $stmt = $conn->prepare("DELETE FROM employees WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        return ['success' => true];
    } else {
        return ['success' => false, 'message' => $stmt->error];
    }
}
function addEmployee($formData) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO employees (name, department, mobile) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $formData['employeeName'], $formData['Clinic'], $formData['phone']);
    if ($stmt->execute()) {
        return ['success' => true, 'id' => $conn->insert_id]; // return the id of the new employee
    } else {
        return ['success' => false, 'message' => $stmt->error];
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    header('Content-Type: application/json');
    
    if ($_POST['action'] === 'delete' && isset($_POST['id'])) {
        $response = deleteEmployee($_POST['id']);
        echo json_encode($response);
        exit;
    }
    elseif ($_POST['action'] === 'add') {
        // Validate and sanitize your inputs before using them
        $formData = [
            'employeeName' => filter_input(INPUT_POST, 'employeeName', FILTER_SANITIZE_STRING),
            'Clinic' => filter_input(INPUT_POST, 'Clinic', FILTER_SANITIZE_STRING),
            'phone' => filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING),
            // Add other fields as needed and validate them
        ];
        $response = addEmployee($formData);
        echo json_encode($response);
    }
    $conn->close();
    exit;
}
$sql = "SELECT id, name, department, mobile FROM employees";
$result = $conn->query($sql);

$employees = []; // Initialize the array.

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $employees[] = $row;
    }
}



$conn->close();
?>
