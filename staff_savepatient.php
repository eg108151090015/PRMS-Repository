<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: loginpage.php");
    exit();
}

require_once "dbconn.php";

// Collect POST data safely
$patient_id   = $_POST['patient_id'] ?? null;
$first        = $_POST['first_name'] ?? '';
$last         = $_POST['last_name'] ?? '';
$middle       = $_POST['middle_name'] ?? '';
$address      = $_POST['address'] ?? '';
$date_of_birth= $_POST['date_of_birth'] ?? '';
$bplace       = $_POST['birth_place'] ?? '';
$status       = $_POST['civil_status'] ?? '';
$gender       = $_POST['gender'] ?? '';
$contact      = $_POST['contact_number'] ?? '';
$email        = $_POST['email_address'] ?? '';
$nationality  = $_POST['nationality'] ?? '';
$religion     = $_POST['religion'] ?? '';
$occupation   = $_POST['occupation'] ?? '';

// Compute age from date of birth
$dob = new DateTime($date_of_birth);
$today = new DateTime();
$age = $today->diff($dob)->y;
$dob_str = $dob->format('Y-m-d');

// Check if updating or inserting
if (!empty($patient_id)) {
    // Check if patient exists
    $check = $conn->prepare("SELECT patient_id FROM patients WHERE patient_id = ?");
    $check->bind_param("i", $patient_id);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        // Update existing record
        $query = $conn->prepare("
            UPDATE patients SET 
                first_name=?, last_name=?, middle_name=?, 
                address=?, age=?, date_of_birth=?, birth_place=?, civil_status=?, 
                gender=?, contact_number=?, email_address=?, nationality=?, religion=?, occupation=?
            WHERE patient_id=?
        ");

        $query->bind_param("ssssisssssssssi", 
            $first, $last, $middle, $address, $age, $dob_str, $bplace,
            $status, $gender, $contact, $email, $nationality, $religion, $occupation, $patient_id
        );

        if ($query->execute()) {
            // Insert log BEFORE exit
            $user_id = $_SESSION['user_id'];
            $fullName = $last . ' ' . $first . ' ' . $middle;
            $action = "Edited patient information (ID: $patient_id, Name: $fullName)";
            $stmt = $conn->prepare("INSERT INTO user_logs (user_id, action) VALUES (?, ?)");
            $stmt->bind_param("is", $user_id, $action);
            $stmt->execute();

            header("Location: staff_viewpatient.php?patient_id=" . $patient_id . "&status=updated");
            exit();
        } else {
            echo "Error updating record: " . $conn->error;
        }
    }
}

// Insert new record
$query = $conn->prepare("
    INSERT INTO patients (
        first_name, last_name, middle_name, address, age, 
        date_of_birth, birth_place, civil_status, gender, contact_number, email_address, 
        nationality, religion, occupation
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
");

$query->bind_param("ssssisssssssss", 
    $first, $last, $middle, $address, $age, $dob_str, $bplace,
    $status, $gender, $contact, $email, $nationality, $religion, $occupation
);


if ($query->execute()) {
    $new_patient_id = $conn->insert_id;

    // Log before exit
    $user_id = $_SESSION['user_id'];
    $fullName = $last . ' ' . $first . ' ' . $middle;
    $action = "Added new patient (ID: $new_patient_id, Name: $fullName)";
    $stmt = $conn->prepare("INSERT INTO user_logs (user_id, action) VALUES (?, ?)");
    $stmt->bind_param("is", $user_id, $action);
    $stmt->execute();

    header("Location: staff_viewpatient.php?patient_id=" . $new_patient_id . "&status=added");
    exit();
} else {
    echo "Error inserting record: " . $query->error;
}
?>
