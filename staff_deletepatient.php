<?php
session_start();
require_once "dbconn.php";

if (!isset($_SESSION["username"])) {
    header("Location: loginpage.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['patient_id'])) {
    $patient_id = intval($_POST['patient_id']);

    $query = $conn->prepare("SELECT * FROM patients WHERE patient_id = ?");
    $query->bind_param("i", $patient_id);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows === 0) {
        $_SESSION['message'] = "Patient not found.";
        header("Location: staffpatient.php");
        exit();
    }

    $patient = $result->fetch_assoc();

    // Ensure the column count matches the value count in the INSERT statement
    $archive = $conn->prepare("
        INSERT INTO archived_patients (
            patient_id, record_id, first_name, middle_name, last_name, address, gender, 
            date_of_birth, birth_place, age, contact_number, email_address, civil_status,
            nationality, religion, occupation
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");
    $archive->bind_param(
        "iisssssssissssss",  // The type definitions should match the columns being bound 
        $patient['patient_id'],
        $patient['record_id'],
        $patient['first_name'],
        $patient['middle_name'],
        $patient['last_name'],
        $patient['address'],  
        $patient['gender'],
        $patient['date_of_birth'],
        $patient['birth_place'],
        $patient['age'],
        $patient['conact_number'],
        $patient['email_address'],
        $patient['civil_status'],
        $patient['nationality'],
        $patient['religion'],
        $patient['occupation'],
    );

    $archive->execute();

    $delete = $conn->prepare("DELETE FROM patients WHERE patient_id = ?");
    $delete->bind_param("i", $patient_id);
    $delete->execute();

    if (!isset($_SESSION['user_id'])) {
        $_SESSION['message'] = "User session expired. Please log in again.";
        header("Location: loginpage.php");
        exit();
    }

    $user_id = $_SESSION['user_id'];
    $fullName = $patient['last_name'] . ' ' . $patient['first_name'] . ' ' . $patient['middle_name'];
    $action = "Archived patient record (ID: $patient_id, Name: $fullName)";
    $stmt = $conn->prepare("INSERT INTO user_logs (user_id, action) VALUES (?, ?)");
    $stmt->bind_param("is", $user_id, $action);
    $stmt->execute();

    $_SESSION['message'] = "Patient archived successfully.";
    header("Location: staffpatient.php?status=archived&patient_id=" . $patient_id);
    exit();
}

header("Location: staffpatient.php");
exit();
?>
