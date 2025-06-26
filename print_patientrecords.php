<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: loginpage.php");
    exit();
}

include('dbconn.php'); // Your DB connection
$patient_id = $_GET['id'] ?? null;

if (!$patient_id) {
    echo "Invalid patient ID.";
    exit();
}

// Fetch patient info
$patient_sql = "SELECT * FROM patients WHERE patient_id = ?";
$stmt = $conn->prepare($patient_sql);
$stmt->bind_param("i", $patient_id);
$stmt->execute();
$patient_result = $stmt->get_result();

if ($patient_result->num_rows === 0) {
    echo "Patient not found.";
    exit();
}

$patient = $patient_result->fetch_assoc();

// Fetch admission record
$admission_sql = "SELECT * FROM admission_records WHERE patient_id = ? ORDER BY record_id DESC LIMIT 1";
$stmt2 = $conn->prepare($admission_sql);
$stmt2->bind_param("i", $patient_id);
$stmt2->execute();
$admission_result = $stmt2->get_result();
$admission = $admission_result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Print Patient Record</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding: 20px;
            font-family: Arial, sans-serif;
            background-color: white;
        }

        .card {
            margin-bottom: 20px;
        }

        .section-header {
            background-color: #3498db;
            color: white;
            padding: 10px;
            font-weight: bold;
        }

        .label {
            font-weight: bold;
        }

        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Print Button -->
        <div class="text-end no-print mb-3">
            <button onclick="window.print()" class="btn btn-primary"><i class="bi bi-printer"></i> Print</button>
        </div>

        <!-- Header -->
        <div class="row mb-4">
            <div class="col-md-8">
                <h4 class="section-header">Patient Name</h4>
                <div class="card p-3">
                    <h5><?= htmlspecialchars($patient['last_name'] . ", " . $patient['first_name']) ?></h5>
                </div>
            </div>
            <div class="col-md-4">
                <h4 class="section-header">Patient No.</h4>
                <div class="card p-3">
                    <h5><?= htmlspecialchars($patient['patient_id']) ?></h5>
                </div>
            </div>
        </div>

        <!-- Patient Information -->
        <div class="row">
            <div class="col-md-6">
                <h5 class="section-header">Patient Information</h5>
                <div class="card p-3">
                    <p><span class="label">Address:</span> <?= htmlspecialchars($patient['address']) ?></p>
                    <p><span class="label">Age:</span> <?= htmlspecialchars($patient['age']) ?></p>
                    <p><span class="label">Birthdate:</span> <?= htmlspecialchars($patient['date_of_birth']) ?></p>
                    <p><span class="label">Birthplace:</span> <?= htmlspecialchars($patient['birth_place']) ?></p>
                    <p><span class="label">Nationality:</span> <?= htmlspecialchars($patient['nationality']) ?></p>
                    <p><span class="label">Religion:</span> <?= htmlspecialchars($patient['religion']) ?></p>
                    <p><span class="label">Civil Status:</span> <?= htmlspecialchars($patient['civil_status']) ?></p>
                    <p><span class="label">Occupation:</span> <?= htmlspecialchars($patient['occupation']) ?></p>
                    <p><span class="label">Gender:</span> <?= htmlspecialchars($patient['gender']) ?></p>
                    <p><span class="label">Contact No.:</span> <?= htmlspecialchars($patient['contact_number']) ?></p>
                    <p><span class="label">Email Address:</span> <?= htmlspecialchars($patient['email_address']) ?></p>
                </div>
            </div>

            <!-- Admission Info -->
            <div class="col-md-6">
                <h5 class="section-header">Admission and Discharge Record</h5>
                <div class="card p-3">
                    <?php if ($admission): ?>
                        <p><span class="label">Admitting Personnel:</span> <?= htmlspecialchars($admission['admitting_personnel']) ?></p>
                        <p><span class="label">Attending Physician:</span> <?= htmlspecialchars($admission['attending_physician']) ?></p>
                        <p><span class="label">Admission Date & Time:</span> <?= htmlspecialchars($admission['admission_datetime']) ?></p>
                        <p><span class="label">Discharge Date & Time:</span> <?= htmlspecialchars($admission['discharge_datetime']) ?></p>
                        <p><span class="label">Type of Admission:</span> <?= htmlspecialchars($admission['admission_type']) ?></p>
                        <p><span class="label">Referred By:</span> <?= htmlspecialchars($admission['referred_by']) ?></p>
                        <p><span class="label">Ward / Services:</span> <?= htmlspecialchars($admission['ward_services']) ?></p>
                        <p><span class="label">Health Insurance:</span> <?= htmlspecialchars($admission['insurance']) ?></p>
                        <p><span class="label">Allergic To:</span> <?= htmlspecialchars($admission['allergic_to']) ?></p>
                        <p><span class="label">Admission Diagnosis:</span> <?= htmlspecialchars($admission['admission_diagnosis']) ?></p>
                        <p><span class="label">Final Diagnosis:</span> <?= htmlspecialchars($admission['final_diagnosis']) ?></p>
                        <p><span class="label">Principal Procedure:</span> <?= htmlspecialchars($admission['procedre']) ?></p>
                        <p><span class="label">Other Procedure(s):</span> <?= htmlspecialchars($admission['other_procedures']) ?></p>
                        <p><span class="label">Accident/Poisoning Code:</span> <?= htmlspecialchars($admission['injury_code']) ?></p>
                        <p><span class="label">Place of Occurrence:</span> <?= htmlspecialchars($admission['place_occurrence']) ?></p>
                        <p><span class="label">Outcome:</span> <?= htmlspecialchars($admission['outcome']) ?></p>
                        <p><span class="label">Disposition:</span> <?= htmlspecialchars($admission['disposition']) ?></p>
                        <p><span class="label">Autopsy:</span> <?= htmlspecialchars($admission['autopsy']) ?></p>
                        <p><span class="label">Data Furnished By:</span> <?= htmlspecialchars($admission['informant_name']) ?></p>
                        <p><span class="label">Relation to Patient:</span> <?= htmlspecialchars($admission['relation']) ?></p>
                        <p><span class="label">Address & Contact #:</span> <?= htmlspecialchars($admission['informant_contact']) ?></p>
                        <p><span class="label">Physician:</span> <?= htmlspecialchars($admission['physician_signature']) ?></p>
                        <p><span class="label">Signature:</span> ________________________</p>
                    <?php else: ?>
                        <p class="text-danger">No admission record found for this patient.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
