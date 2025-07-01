<?php
// Database Connection
session_start();
$conn = new mysqli("localhost", "root", "", "web_system_Finals");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get patient_id from URL
$patient_id = $_GET['patient_id'] ?? null;
if (!$patient_id) {
    die("No patient ID provided.");
}

// Only fetch fields that exist in your table
$stmt = $conn->prepare("SELECT patient_id, last_name, first_name, middle_name, gender, date_of_birth, birth_place, age, contact_number, email_address, address, civil_status, nationality, religion, occupation FROM patients WHERE patient_id = ?");
$stmt->bind_param("i", $patient_id);
$stmt->execute();
$patient = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$patient) {
    die("Patient not found.");
}
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

        .hospital-info {
            text-align: center;
            line-height: 1.2;
        }

        .signature-space {
            height: 50px;
            border-bottom: 1px solid black;
        }

        @media print {
            @page {
                size: legal portrait;
                margin: 1in;
            }

            body {
                margin: 0;
                padding: 0;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .no-print {
                display: none !important;
            }
        }

        .custom-cell {
            height: 60px;
            padding: 5px;
        }

        .custom-cell .label {
            display: block;
            font-weight: bold;
            text-align: left;
            font-size: 13px;
        }

        .custom-cell .data {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
            text-align: center;
            font-size: 14px;
        }
    </style>
</head>

<body>

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <img src="pictures/logo_hospital.png" class="header-logo" alt="Hospital Logo" width="110px" height="110px">
        <div class="hospital-info">
            <p>Republic of the Philippines<br>OSPITAL NG TAGAYTAY<br>Maitim II East, Tagaytay City<br>E-mail Address:
                ont97_tagaytay@yahoo.com.ph<br>PHILHEALTH ACCREDITED</p>
        </div>
        <div>
            <img src="pictures/Seal_of_Tagaytay_City.png" class="header-logo" alt="Hospital Logo" width="100px"
                height="100px">
        </div>
    </div>

    <p>========================================================================================</p>

    <p style="display: flex; justify-content: space-between;">__________ New Patient
        <span><u><?= $patient['patient_id'] ?? ''; ?></u></span>
    </p>
    <p style="display: flex; justify-content: space-between;">__________ Revisit <span>OPD PATIENT NO.</span></p>
    <p>__________ Last Visit</p>

    <div class="text-center">
        <h5>MEDICAL RECORD<br>OUT-PATIENT DEPARTMENT</h5>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered">
            <!-- Date and Name -->
            <tr>
                <td colspan="2" class="custom-cell">
                    <span class="label">Date and Time:</span>
                    <div class="data"><?= $patient['date_time'] ?? ''; ?></div>
                </td>
                <td class="custom-cell">
                    <span class="label">Last Name:</span>
                    <div class="data"><?= $patient['last_name'] ?? ''; ?></div>
                </td>
                <td class="custom-cell">
                    <span class="label">First Name:</span>
                    <div class="data"><?= $patient['first_name'] ?? ''; ?></div>
                </td>
                <td class="custom-cell">
                    <span class="label">Middle Name:</span>
                    <div class="data"><?= $patient['middle_name'] ?? ''; ?></div>
                </td>
            </tr>
        </table>

        <table class="table table-bordered">
            <!-- Birth, Age, Sex, Address -->
            <tr>
                <td class="custom-cell">
                    <span class="label">Birthdate:</span>
                    <div class="data"><?= $patient['date_of_birth'] ?? ''; ?></div>
                </td>
                <td class="custom-cell">
                    <span class="label">Age:</span>
                    <div class="data"><?= $patient['age'] ?? ''; ?></div>
                </td>
                <td class="custom-cell">
                    <span class="label">Sex:</span>
                    <div class="data"><?= $patient['gender'] ?? ''; ?></div>
                </td>
                <td colspan="2" class="custom-cell">
                    <span class="label">Present Address:</span>
                    <div class="data"><?= $patient['address'] ?? ''; ?></div>
                </td>
            </tr>
        </table>

        <table class="table table-bordered">
            <!-- Contact and Physician -->
            <tr>
                <td colspan="2" class="custom-cell">
                    <span class="label">Telephone / Cellphone #:</span>
                    <div class="data"><?= $patient['contact_number'] ?? ''; ?></div>
                </td>
                <td colspan="3" class="custom-cell">
                    <span class="label">Attending Physician:</span>
                    <div class="data"></div>
                </td>
            </tr>
        </table>

        <table class="table table-bordered">
            <!-- Complaint and Vitals -->
            <tr>
                <td colspan="5" class="custom-cell">
                    <span class="label">Chief Complaint:</span>
                    <div class="data"></div>
                </td>
                <td class="custom-cell">
                    <span class="label">BP:</span>
                    <div class="data"></div>
                </td>
                <td class="custom-cell">
                    <span class="label">PR:</span>
                    <div class="data"></div>
                </td>
                <td class="custom-cell">
                    <span class="label">RR:</span>
                    <div class="data"></div>
                </td>
                <td class="custom-cell">
                    <span class="label">Temp:</span>
                    <div class="data"></div>
                </td>
                <td class="custom-cell">
                    <span class="label">Weight:</span>
                    <div class="data"></div>
                </td>
                <td class="custom-cell">
                    <span class="label">Height:</span>
                    <div class="data"></div>
                </td>
            </tr>
            </tr>
        </table>
    </div>

    <div class="text-justify" style="text-indent: 40px;">
        <p>
            CONSENT: I hereby give my consent to the Doctor and staff of Ospital Ng Tagaytay to examine me/my patient as
            necessary including all diagnostic test and procedures, and if I/the patient needs an immediate
            test/treatment not
            available in the hospital, I voluntarily suggest to transfer to other hospital without hesitation after
            I/the patient was
            given initial treatment and/or medications.
        </p>
    </div>

    <p style="display: flex; justify-content: flex-end;">______________________________</p>
    <p style="display: flex; justify-content: flex-end;">Full Name with Signature / Relationship</p>

    <div class="table-responsive">
        <table class="table table-bordered">
            <!-- History -->
            <tr>
                <td colspan="2" style="font-weight: bold; font-size: 13px;"><span class="label">HISTORY OF PRESENT
                        ILLNESS (HPI):</span></td>
            </tr>
        </table>
    </div>
    <br>
    <br>
    <br>
    <div class="table-responsive">
        <table class="table table-bordered">
            <!-- Impressions -->
            <tr>
                <td colspan="2" style="font-weight: bold; font-size: 13px;"><span
                        class="label">IMPRESSIONS/DIAGNOSIS:</span></td>
            </tr>
        </table>
    </div>
    <br>
    <br>
    <br>
    <div class="table-responsive">
        <table class="table table-bordered">
            <!-- Treatment -->
            <tr>
                <td colspan="2" style="font-weight: bold; font-size: 13px;"><span
                        class="label">TREATMENT/MEDICATION:</span></td>
                <td style="font-weight: bold; font-size: 13px;"><span class="label">Motor:</span></td>
                <td style="font-weight: bold; font-size: 13px;"><span class="label">Sensor:</span></td>
                <td style="font-weight: bold; font-size: 13px;"><span class="label">Reflex:</span></td>
            </tr>
        </table>
    </div>

    <br>
    <br>
    <br>
    <br>
    <br>

    <p style="display: flex; justify-content: flex-end;">
        <span style="margin-left: 50px;">Glasgow Coma Scale: E:</span>
        <span style="margin-left: 50px;">V:</span>
        <span style="margin-left: 50px;">M:</span>
    </p>

    <br>
    <br>

    <p style="display: flex; justify-content: flex-end;">___________________</p>
    <p style="display: flex; justify-content: flex-end;">PHYSICIAN SIGNATURE</p>

    <div class="no-print">
        <?php

        $backLink = "#"; // default link
        if (isset($_SESSION['role'])) {
            if ($_SESSION['role'] === 'admin') {
                $backLink = "viewpatient.php";
            } elseif ($_SESSION['role'] === 'staff') {
                $backLink = "staff_viewpatient.php";
            }
        }
        ?>
        <a href="<?= $backLink ?>?patient_id=<?= urlencode($patient['patient_id']) ?>"
            class="btn btn-secondary">Back</a>
        <button onclick="window.print()" class="btn btn-primary">Print</button>
    </div>

    <script>
        window.onload = () => {
            window.print();
        };
    </script>

</body>

</html>