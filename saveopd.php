<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: loginpage.php");
    exit();
}

require_once "dbconn.php";

// Collect form inputs
$patient_id         = $_POST['patient_id'];
$date_time          = $_POST['date_time'];
$attending_physician = $_POST['attending_physician'];
$chief_complaint    = $_POST['chief_complaint'];
$bp                 = $_POST['bp'];
$pr                 = $_POST['pr'];
$rr                 = $_POST['rr'];
$temp               = $_POST['temp'];
$weight             = $_POST['weight'];
$height             = $_POST['height'];
$history_of_present_illness = $_POST['history_of_present_illness'];
$impressions_diagnosis = $_POST['impressions_diagnosis'];
$treatment_medications = $_POST['treatment_medications'];

// Insert OPD record
$query = $conn->prepare("
    INSERT INTO opd_records (
        patient_id, date_time, attending_physician, chief_complaint,
        bp, pr, rr, temp, weight, height, history_of_present_illness, impressions_diagnosis, treatment_medications
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
");

$query->bind_param(
    "issssssssssss",
    $patient_id, $date_time, $attending_physician, $chief_complaint,
    $bp, $pr, $rr, $temp, $weight, $height, $history_of_present_illness, $impressions_diagnosis, $treatment_medications,
);

if ($query->execute()) {
    header("Location: viewpatient.php?patient_id=" . $patient_id);
    exit();
} else {
    echo "Error saving OPD record: " . $conn->error;
}
?>
