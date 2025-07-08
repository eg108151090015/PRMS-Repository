<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: loginpage.php");
    exit();
}

require_once "dbconn.php";

// Check if user_id is provided via GET
if (!isset($_GET['patient_id'])) {
    echo "No patient ID provided.";
    exit();
}

$patient_id = intval($_GET['patient_id']);

// Fetch archived user record
$query = $conn->prepare("SELECT * FROM archived_patients WHERE patient_id = ?");
$query->bind_param("i", $patient_id);
$query->execute();
$result = $query->get_result();

if ($result->num_rows === 0) {
    echo "Archived patient not found.";
    exit();
}

$archived = $result->fetch_assoc();

// Insert back into users table
$insert = $conn->prepare("
    INSERT INTO patients (
        first_name, middle_name, last_name, address, gender, 
        date_of_birth, birth_place, age, contact_number, email_address, civil_status,
        nationality, religion, occupation
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
");
$insert->bind_param(
    "sssssssissssss",
    $archived['first_name'],
    $archived['middle_name'],
    $archived['last_name'],
    $archived['address'],  
    $archived['gender'],
    $archived['date_of_birth'],
    $archived['birth_place'],
    $archived['age'],
    $archived['contact_number'],
    $archived['email_address'],
    $archived['civil_status'],
    $archived['nationality'],
    $archived['religion'],
    $archived['occupation']
);
$insert->execute();

// Delete from archived_patients table
$delete = $conn->prepare("DELETE FROM archived_patients WHERE patient_id = ?");
$delete->bind_param("i", $patient_id);
$delete->execute();

$user_id = $_SESSION['user_id'];
$fullName = $archived['last_name'] . ' ' . $archived['first_name'] . ' ' . $archived['middle_name'];
$action = "Restored patient information (ID: $patient_id, Name: $fullName)";
$stmt = $conn->prepare("INSERT INTO user_logs (user_id, action) VALUES (?, ?)");
$stmt->bind_param("is", $user_id, $action);
$stmt->execute();

// Redirect back to archived users page
header("Location: staff_archivedpatient.php?status=restored&patient_id=" . $patient_id);
exit();
?>
