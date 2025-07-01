<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: loginpage.php");
    exit();
}

require_once 'dbconn.php';

// Example: Get patient ID from URL
$patient_id = $_GET['patient_id'] ?? '';

$query = "SELECT * FROM patients WHERE patient_id = '$patient_id'";
$result = mysqli_query($conn, $query);
$patient = mysqli_fetch_assoc($result);

$sql = "SELECT * FROM admission_records WHERE patient_id = '$patient_id' ORDER BY record_id DESC LIMIT 1";
$res_sql = mysqli_query($conn, $sql);
$record = mysqli_fetch_assoc($res_sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admission and Discharge Record</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: white;
            padding: 30px;
        }

        .record-box {
            border: 1px solid black;
            padding: 15px;
            margin-bottom: 20px;
        }

        .section-title {
            font-weight: bold;
            text-align: center;
            margin-bottom: 10px;
            text-transform: uppercase;
        }

        .bordered {
            border: 1px solid black;
            padding: 5px;
        }

        .label {
            font-weight: bold;
        }

        table td {
            vertical-align: top;
        }

        .header-logo {
            width: 70px;
        }

        .hospital-info {
            text-align: center;
            line-height: 1.2;
        }

        .signature-space {
            height: 50px;
            border-bottom: 1px solid black;
        }

        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <img src="pictures/logo_hospital.png" class="header-logo" alt="Hospital Logo">
        <div class="hospital-info">
            <h5>PATIENT RECORD MANAGEMENT SYSTEM</h5>
            <p>Sample Place, Sample City<br>Tel: (012) 345-6789</p>
        </div>
        <div>
            <p><strong>HOSPITAL CODE:</strong> H100000001</p>
            <p><strong>MEDICAL RECORD NO:</strong> <?php echo $record['record_id'] ?? '_________'; ?></p>
        </div>
    </div>

    <h4 class="section-title">Admission and Discharge Record</h4>

    <!-- Patient Details -->
    <div class="record-box">
        <table class="table table-bordered">
            <tr>
                <td colspan="3"><span class="label">Patient's Name:</span> <?php echo $patient['last_name'] . ', ' . $patient['first_name']; ?></td>
                <td><span class="label">Sex:</span> <?php echo $patient['gender']; ?></td>
                <td><span class="label">Civil Status:</span> <?php echo $patient['civil_status'] ?? ''; ?></td>
            </tr>
            <tr>
                <td colspan="5"><span class="label">Address:</span> <?php echo $patient['address'] ?? ''; ?></td>
            </tr>
            <tr>
                <td><span class="label">Birthdate:</span> <?php echo $patient['date_of_birth'] ?? ''; ?></td>
                <td><span class="label">Age:</span> <?php echo $patient['age']; ?></td>
                <td><span class="label">Birthplace:</span> <?php echo $patient['birth_place'] ?? ''; ?></td>
                <td><span class="label">Nationality:</span> <?php echo $patient['nationality'] ?? ''; ?></td>
                <td><span class="label">Religion:</span> <?php echo $patient['religion'] ?? ''; ?></td>
            </tr>
            <tr>
                <td colspan="2"><span class="label">Occupation:</span> <?php echo $patient['occupation'] ?? ''; ?></td>
            </tr>
        </table>
    </div>

    <!-- Admission Details -->
    <div class="record-box">
        <table class="table table-bordered">
            <tr>
                <td><span class="label">Admission Date/Time:</span> <?php echo $record['admission_datetime'] ?? ''; ?></td>
                <td><span class="label">Discharge Date/Time:</span> <?php echo $record['discharge_datetime'] ?? ''; ?></td>
                <td><span class="label">Total Days:</span> <?php echo $record['total_days'] ?? ''; ?></td>
            </tr>
            <tr>
                <td><span class="label">Type of Admission:</span> <?php echo $record['admission_type'] ?? ''; ?></td>
                <td colspan="2"><span class="label">Attending Physician:</span> Dr. <?php echo $record['attending_physician'] ?? ''; ?></td>
            </tr>
        </table>
    </div>

    <!-- Medical Section -->
    <div class="record-box">
        <table class="table table-bordered">
            <tr>
                <td colspan="2"><span class="label">Allergies:</span> <br> <?php echo $record['allergic_to'] ?? ''; ?></td>
                <td><span class="label">Health Insurance:</span> <br> <?php echo $record['insurance'] ?? ''; ?></td>
            </tr>
            <tr>
                <td><span class="label">Data Furnished By:</span> <?php echo $record['admission_diagnosis'] ?? ''; ?></td>
                <td><span class="label">Adress / Contact No. of Informant:</span> <?php echo $record['final_diagnosis'] ?? ''; ?></td>
                <td><span class="label">Relation to Patient:</span> <?php echo $record['referred_by'] ?? ''; ?></td>
            </tr>

        </table>

        <table class="table table-bordered">
            <tr>
                <td colspan="5"><span class="label">Admission Diagnosis:</span> <?php echo $record['admission_diagnosis'] ?? ''; ?></td>
            </tr>
            <tr>
                <td colspan="2"><span class="label">Final Diagnosis:</span> <?php echo $record['final_diagnosis'] ?? ''; ?></td>
                <td><span class="label">Referred By:</span> <?php echo $record['referred_by'] ?? ''; ?></td>
            </tr>
        </table>

        <table class="table table-bordered">
        <tr>
                <td colspan="6"><span class="label">Procedure:</span> <?php echo $record['procedre'] ?? ''; ?></td>
            </tr>
            <tr>
                <td colspan="6"><span class="label">Other Procedure:</span> <?php echo $record['other_procedures'] ?? ''; ?></td>
            </tr>
            <tr>
                <td colspan="6"><span class="label">Accident / Injury / Poisoning Code:</span> <?php echo $record['outcome'] ?? ''; ?></td>
            </tr>
            <tr>
                <td colspan="6"><span class="label">Place of Occurrence:</span> <?php echo $record['place_occurrence'] ?? ''; ?></td>
            </tr>
            <tr>
                <td colspan="2"><span class="label">Disposition:</span> <br><br> <?php echo $record['disposition'] ?? ''; ?></td>
                <td colspan="3"><span class="label">Outcome:</span> <br><br> <?php echo $record['outcome'] ?? ''; ?></td>
                <td colspan="6"><span class="label">Attending Physician Signature: </span>
                    <div class="signature-space"></div> </td>
            </tr>
        </table>
    </div>

    <div class="no-print">
        <a href="staffreports.php" class="btn btn-secondary">Back</a>
        <button onclick="window.print()" class="btn btn-primary">Print</button>
    </div>

</body>
</html>
