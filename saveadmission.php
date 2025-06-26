<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: loginpage.php");
    exit();
}

require_once "dbconn.php";

// Collect form inputs
$patient_id           = $_POST['patient_id'];
$admitting_personnel  = $_POST['admitting_personnel'];
$admission_datetime   = $_POST['admission_datetime'];
$admission_type       = $_POST['admission_type'];
$referred_by          = $_POST['referred_by'];
$attending_physician  = $_POST['attending_physician'];
$discharge_datetime   = $_POST['discharge_datetime'];
$ward_services        = $_POST['ward_services'];
$insurance            = $_POST['insurance'];
$allergic_to          = $_POST['allergic_to'];
$admission_diagnosis  = $_POST['admission_diagnosis'];
$final_diagnosis      = $_POST['final_diagnosis'];
$procedure            = $_POST['procedure'];
$other_procedures     = $_POST['other_procedures'];
$injury_code          = $_POST['injury_code'];
$place_occurrence     = $_POST['place_occurrence'];
$disposition          = $_POST['disposition'];
$outcome              = $_POST['outcome'];
$autopsy              = $_POST['autopsy'];
$informant_name       = $_POST['informant_name'];
$relation             = $_POST['relation'];
$informant_contact    = $_POST['informant_contact'];
$physician_signature  = $_POST['physician_signature'];

$admitDate = new DateTime($admission_datetime);
$dischDate = new DateTime($discharge_datetime);
$total_days = $dischDate->diff($admitDate)->d;

// Check if a record already exists
$check = $conn->prepare("SELECT * FROM admission_records WHERE patient_id = ?");
$check->bind_param("i", $patient_id);
$check->execute();
$result = $check->get_result();

if ($result->num_rows > 0) {
    // Update existing record
    $query = $conn->prepare("
        UPDATE admission_records SET
            admitting_personnel=?, admission_datetime=?, admission_type=?, referred_by=?,
            attending_physician=?, discharge_datetime=?, total_days=?, ward_services=?,
            insurance=?, allergic_to=?, admission_diagnosis=?, final_diagnosis=?,
            procedre=?, other_procedures=?, injury_code=?, place_occurrence=?, disposition=?,
            outcome=?, autopsy=?, informant_name=?, relation=?, informant_contact=?, physician_signature=?
        WHERE patient_id=?
    ");
} else {
    // Insert new record
    $query = $conn->prepare("
        INSERT INTO admission_records (
            admitting_personnel, admission_datetime, admission_type, referred_by,
            attending_physician, discharge_datetime, total_days, ward_services,
            insurance, allergic_to, admission_diagnosis, final_diagnosis,
            procedre, other_procedures, injury_code, place_occurrence, disposition,
            outcome, autopsy, informant_name, relation, informant_contact, physician_signature, patient_id
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");
}

$query->bind_param(
    "ssssssissssssssssssssssi",
    $admitting_personnel, $admission_datetime, $admission_type, $referred_by,
    $attending_physician, $discharge_datetime, $total_days, $ward_services,
    $insurance, $allergic_to, $admission_diagnosis, $final_diagnosis, 
    $procedre, $other_procedures, $injury_code, $place_occurrence, $disposition,
    $outcome, $autopsy, $informant_name, $relation, $informant_contact, $physician_signature,
    $patient_id
);

if ($query->execute()) {
    header("Location: viewpatient.php?patient_id=" . $patient_id );
    exit();
} else {
    echo "Error saving record: " . $conn->error;
}
