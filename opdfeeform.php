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
<html>

<head>
    <title>Doctor's Professional Fee Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .hospital-info {
            text-align: center;
            line-height: 1.2;
        }

        .form-title {
            font-weight: bold;
            text-align: center;
            text-decoration: underline;
            margin-top: 20px;
        }

        .signature-line {
            border-top: 1px solid #000;
            height: 2px;
            margin-top: 30px;
        }

        .section-label {
            text-align: center;
            font-size: 12px;
        }

        .table td,
        .table th {
            vertical-align: middle;
            text-align: center;
        }

        @media print {
            @page {
                size: letter portrait;
                margin: 0.25in;
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
    </style>

</head>

<body class="container mt-5">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <img src="pictures/logo_hospital.png" class="header-logo" alt="Hospital Logo" width="110px" height="110px">
        <div class="hospital-info">
            <p>Republic of the Philippines<br>OSPITAL NG TAGAYTAY<br>Maitim II East, Tagaytay City<br>E-mail Address:
                ont97_tagaytay@yahoo.com.ph<br>Telephone No. 888-9510<br>PHILHEALTH ACCREDITED</p>
        </div>
        <div>
            <img src="pictures/Seal_of_Tagaytay_City.png" class="header-logo" alt="Hospital Logo" width="100px"
                height="100px">
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered">
            <tr>
                <td colspan="2" class="custom-cell">
                    <h5 class="form-title">DOCTOR’S PROFESSIONAL FEE FORM</h5>
                    <br>
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <div style="text-align: left;">
                            Name of Patient: 
                            <u>
                                <?= htmlspecialchars(
                                    $patient['last_name'] . ', '
                                    . $patient['first_name'] . ' '
                                    . strtoupper(substr($patient['middle_name'], 0, 1)) . '.'
                                ) ?>
                            </u>
                        </div>
                        <div style="text-align: center;">
                            Room #: ___________
                        </div>
                    </div>

                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <div style="text-align: left;">
                            Date and Time Admitted:____________________
                        </div>
                        <div style="text-align: center;">
                            Date and Time Discharged:____________________
                        </div>
                    </div>
                </td>
            </tr>

        </table>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ATTENDING PHYSICIAN</th>
                    <th>PROFESSIONAL FEE (PF)</th>
                    <th>REMARKS</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <div style="align-items: center;">
                            <div style="text-align: center;">
                                ______________________________
                            </div>
                        </div>
                        <div style="align-items: center;">
                            <div style="text-align: center;">
                                Signature Over Printed Name
                            </div>
                        </div>
                    </td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>
                        <div style="align-items: center;">
                            <div style="text-align: center;">
                                ______________________________
                            </div>
                        </div>
                        <div style="align-items: center;">
                            <div style="text-align: center;">
                                Signature Over Printed Name
                            </div>
                        </div>
                    </td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>
                        <div style="align-items: center;">
                            <div style="text-align: center;">
                                ______________________________
                            </div>
                        </div>
                        <div style="align-items: center;">
                            <div style="text-align: center;">
                                Signature Over Printed Name
                            </div>
                        </div>
                    </td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>
                        <div style="align-items: center;">
                            <div style="text-align: center;">
                                ______________________________
                            </div>
                        </div>
                        <div style="align-items: center;">
                            <div style="text-align: center;">
                                Signature Over Printed Name
                            </div>
                        </div>
                    </td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- First Row: Labels -->
    <div style="display: flex; justify-content: space-between; padding: 0 40px;">
        <span>Prepared by:</span>
        <span>Conformed:</span>
    </div>

    <!-- Second Row: Signature Lines -->
    <div style="display: flex; justify-content: space-between; padding: 0 40px; margin-top: 20px;">
        <span>_____________________________</span>
        <span>_____________________________</span>
    </div>

    <!-- Third Row: Signature Labels -->
    <div style="display: flex; justify-content: space-between; padding: 0 40px;">
        <span>Signature Over Printed Name</span>
        <span>Signature Over Printed Name</span>
    </div>

    <!-- Fourth Row: Titles -->
    <div style="display: flex; justify-content: space-between; padding: 0 40px;">
        <span>NURSING SERVICE STAFF</span>
        <span>BILLING SECTION</span>
    </div>

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
<?php $conn->close(); ?>