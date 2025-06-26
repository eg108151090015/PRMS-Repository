<?php

// staff_viewpatient.php

session_start();
if (!isset($_SESSION["username"])) {
    header("Location: loginpage.php");
    exit();
}

require_once "dbconn.php";

if (!isset($_GET['patient_id'])) {
    echo "No patient ID provided.";
    exit();
}

$showEditModal = isset($_GET['edit']) && $_GET['edit'] === 'true';

$patient_id = intval($_GET['patient_id'] ?? null);
$query = $conn->prepare("SELECT * FROM patients WHERE patient_id = ?");
$query->bind_param("i", $patient_id);
$query->execute();
$result = $query->get_result();

$patient = $result->fetch_assoc();

$admission_query = $conn->prepare("SELECT * FROM admission_records WHERE patient_id = ?");
$admission_query->bind_param("i", $patient_id);
$admission_query->execute();
$admission_result = $admission_query->get_result();
$admission = $admission_result->fetch_assoc(); // Will be false if no record exists

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Patient Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
    body {
        overflow-x: hidden;
        background-color: #f2f2f2;
    }

    .bg-custom {
        background-color: #3498db !important;
    }

    .bg-sidebar-custom {
        background-color: rgb(52, 52, 65) !important;
    }

    .nav-link {
        color: white;
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    .nav-link:hover {
        background-color: rgb(25, 90, 134);
        color: white;
    }

    .nav-link.active {
        background-color: white !important;
        color: black !important;
        font-weight: bold;
    }

    .content {
        margin-left: 250px;
        padding: 90px 20px 20px 20px;
    }

    .border-start-custom {
        border-left: 7px solid #3498db !important;
        /* Bootstrap primary */

    }

    .text-custom-blue {
        color: #3498db !important;
    }

    /* Show dropdown on hover */
    .patient-dropdown:hover .dropdown-menu {
        display: block;
        margin-top: 0;
    }
    </style>
</head>

<body>

    <?php include 'sidebar_staff.php'; ?>

    <!-- Main Content -->
    <div class="content">
        <div class="container-fluid">

            <!-- Back Button -->
            <div class="mb-3">
                <a href="staffpatient.php" class="btn bg-custom text-white">
                    <i class="bi bi-arrow-left"></i> Back to Patient List
                </a>
            </div>

            <div class="row">
                <!-- Patient Name Card -->
                <div class="col-md-8 mb-3">
                    <div class="card shadow-sm border-0 border-start-custom">
                        <div class="card-body">
                            <h6 class="text-custom-blue">Patient Name</h6>
                            <h4 class="mb-0">
                                <?= htmlspecialchars($patient['last_name'] . ', ' . $patient['first_name'] . ' ' . $patient['middle_name']) ?>
                            </h4>
                        </div>
                    </div>
                </div>

                <!-- Hospital Case No. Card -->
                <div class="col-md-4 mb-3">
                    <div class="card shadow-sm border-0 border-start-custom">
                        <div class="card-body">
                            <h6 class="text-custom-blue">Patient No.</h6>
                            <h4 class="mb-0"><?= htmlspecialchars($patient['patient_id'] ) ?></h4>
                            <!-- Replace with dynamic value if available -->
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <!-- Patient Information Card -->
                <div class="col-md-4 mb-3">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-header text-custom-blue d-flex justify-content-between align-items-center">
                            <h6 class="mb-0">Patient Information</h6>
                            <a href="#" class="text-decoration-none text-custom-blue" data-bs-toggle="modal"
                                data-bs-target="#editPatientModal">
                                <i class="bi bi-pencil-square"></i>
                            </a>

                        </div>
                        <div class="card-body">
                            <p>ADDRESS:<br> <strong><?= htmlspecialchars($patient['address']) ?></strong></p>
                            <p>AGE:<br> <strong><?= htmlspecialchars($patient['age']) ?></strong></p>
                            <p>BIRTHDATE:<br> <strong><?= htmlspecialchars($patient['date_of_birth']) ?></strong></p>
                            <p>BIRTHPLACE:<br> <strong><?= htmlspecialchars($patient['birth_place']) ?></strong></p>
                            <p>NATIONALITY:<br> <strong><?= htmlspecialchars($patient['nationality']) ?></strong></p>
                            <p>RELIGION:<br> <strong><?= htmlspecialchars($patient['religion']) ?></strong></p>
                            <p>CIVIL STATUS:<br> <strong><?= htmlspecialchars($patient['civil_status']) ?></strong></p>
                            <p>OCCUPATION:<br> <strong><?= htmlspecialchars($patient['occupation']) ?></strong></p>
                            <p>GENDER:<br> <strong><?= htmlspecialchars($patient['gender']) ?></strong></p>
                            <p>CONTACT NO.:<br> <strong><?= htmlspecialchars($patient['contact_number']) ?></strong></p>
                            <p>EMAIL ADDRESS:<br> <strong><?= htmlspecialchars($patient['email_address']) ?></strong>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- OPD Record Card -->
                <div class="col-md-8 mb-3">
                    <div class="card shadow-sm border-0 h-100">

                        <!-- Header -->
                        <div class="card-header text-custom-blue d-flex justify-content-between align-items-center">
                            <h6 class="mb-0">OUT-PATIENT DEPARTMENT (OPD) RECORD</h6>
                            <a href="#" class="text-decoration-none text-custom-blue" data-bs-toggle="modal" data-bs-target="#opdModal">
                                <i class="bi bi-plus-square"></i>
                            </a>
                        </div>

                        <div class="card-body">
                            <?php
                            // Fetch OPD records for this patient
                            $opd_query = $conn->prepare("SELECT * FROM opd_records WHERE patient_id = ?");
                            $opd_query->bind_param("i", $patient_id);
                            $opd_query->execute();
                            $opd_result = $opd_query->get_result();
                            ?>

                            <?php if ($opd_result->num_rows > 0): ?>
                                <?php while ($opd = $opd_result->fetch_assoc()): ?>
                                    <div class="mb-4 border-bottom pb-2">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <p>Date & Time:<strong> <?= htmlspecialchars($opd['date_time']) ?></strong></p>
                                                <p>Attending Physician:<strong> <?= htmlspecialchars($opd['attending_physician']) ?></strong></p>
                                                <p>Chief Complaint:<strong> <?= htmlspecialchars($opd['chief_complaint']) ?></strong></p>
                                            </div>
                                            <div class="col-sm-6">
                                                <p>BP:<strong> <?= htmlspecialchars($opd['bp']) ?> </strong>
                                                | PR:<strong> <?= htmlspecialchars($opd['pr']) ?> </strong>
                                                | RR:<strong> <?= htmlspecialchars($opd['rr']) ?></p></strong>
                                                <p>Temp:<strong> <?= htmlspecialchars($opd['temp']) ?> </strong>
                                                | Wt:<strong> <?= htmlspecialchars($opd['weight']) ?> </strong>
                                                | Ht:<strong> <?= htmlspecialchars($opd['height']) ?> </strong></p>
                                            </div>
                                        </div>
                                        <p>Signature:<strong> ____________________</strong></p>
                                    </div>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <p class="text-muted">No OPD record found for this patient.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Admission / Findings Card -->
                <div class="col-md-8 mb-3">
                    <div class="card shadow-sm border-0 h-100">

                        <!-- Header -->
                        <div class="card-header text-custom-blue d-flex justify-content-between align-items-center">
                            <h6 class="mb-0">ADMISSION AND DISCHARGE RECORD</h6>
                            <a href="#" class="text-decoration-none text-custom-blue" data-bs-toggle="modal"
                                data-bs-target="#admissionModal">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-sm-15">
                                    <?php if ($admission): ?>
                                    <div class="row mb-3">

                                        <div class="col-sm-6">
                                            <!-- Part 1 -->
                                            <p>Admitting Personnel:
                                                <strong><?= htmlspecialchars($admission['admitting_personnel']) ?></strong>
                                            </p>
                                            <p>Admission Date & Time:
                                                <strong><?= htmlspecialchars($admission['admission_datetime']) ?></strong>
                                            </p>
                                            <p>Type of Admission:
                                                <strong><?= htmlspecialchars($admission['admission_type']) ?></strong>
                                            </p>
                                            <p>Referred By:
                                                <strong><?= htmlspecialchars($admission['referred_by']) ?></strong>
                                            </p>
                                        </div>

                                        <div class="col-sm-6">
                                            <!-- Part 2 -->
                                            <p>Attending Physician:
                                                <strong><?= htmlspecialchars($admission['attending_physician']) ?></strong>
                                            </p>
                                            <p>Discharge Date & Time:
                                                <strong><?= htmlspecialchars($admission['discharge_datetime']) ?></strong>
                                            </p>
                                            <p>Total No. of Days:
                                                <strong><?= htmlspecialchars($admission['total_days']) ?></strong>
                                            </p>
                                            <p>Ward / Services:
                                                <strong><?= htmlspecialchars($admission['ward_services']) ?></strong>
                                            </p>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-sm-6">
                                            <!-- Part 3 -->
                                            <p>Health Insurance /
                                                Benefits:<br><strong><?= htmlspecialchars($admission['insurance']) ?></strong>
                                            </p>
                                        </div>
                                        <div class="col-sm-6">
                                            <p>Allergic To:
                                                <strong><?= htmlspecialchars($admission['allergic_to']) ?></strong>
                                            </p>
                                        </div>
                                    </div>

                                    <hr>

                                    <!-- Part 4 -->
                                    <p>Admission Diagnosis:
                                        <strong><?= htmlspecialchars($admission['admission_diagnosis']) ?></strong>
                                    </p>
                                    <p>Final Diagnosis:
                                        <strong><?= htmlspecialchars($admission['final_diagnosis']) ?></strong>
                                    </p>

                                    <hr>

                                    <!-- Part 5 -->
                                    <p>Principal Operation / Procedure:
                                        <strong><?= htmlspecialchars($admission['procedre']) ?></strong>
                                    </p>
                                    <p>Other Procedure(s):
                                        <strong><?= htmlspecialchars($admission['other_procedures']) ?></strong>
                                    </p>
                                    <p>Accident / Injury / Poisoning Code:
                                        <strong><?= htmlspecialchars($admission['injury_code']) ?></strong>
                                    </p>

                                    <div class="row mb-3">
                                        <div class="col-sm-6">
                                            <!-- Part 6 -->
                                            <p>Place of Occurrence:
                                                <strong><?= htmlspecialchars($admission['place_occurrence']) ?></strong>
                                            </p>
                                            <p>Disposition:
                                                <strong><?= htmlspecialchars($admission['disposition']) ?></strong>
                                            </p>
                                        </div>

                                        <div class="col-sm-6">
                                            <!-- Part 7 -->
                                            <p>Outcome: <strong><?= htmlspecialchars($admission['outcome']) ?></strong>
                                            </p>
                                            <p>Autopsy: <strong><?= htmlspecialchars($admission['autopsy']) ?></strong>
                                            </p>
                                        </div>
                                    </div>

                                    <hr>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <p>Data Furnished By:
                                                <strong><?= htmlspecialchars($admission['informant_name']) ?></strong>
                                            </p>
                                            <p>Relation to Patient:
                                                <strong><?= htmlspecialchars($admission['relation']) ?></strong>
                                            </p>
                                            <p>Address & Contact #:
                                                <strong><?= htmlspecialchars($admission['informant_contact']) ?></strong>
                                            </p>
                                        </div>
                                        <div class="col-sm-6 text-rignt">
                                            <p>Physician: 
                                                <strong><?= htmlspecialchars($admission['physician_signature']) ?></strong>
                                            </p>
                                            <p>Signature:<strong> ____________________</strong></p>
                                        </div>
                                    </div>
                                    <?php else: ?>
                                    <p class="text-muted">No admission record found for this patient.</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Edit Patient Modal -->
    <div class="modal fade" id="editPatientModal" tabindex="-1" aria-labelledby="editPatientModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="staff_savepatient.php" method="post">
                    <div class="modal-header bg-custom text-white">
                        <h5 class="modal-title" id="editPatientModalLabel">Edit Patient Information</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="patient_id" value="<?= $patient_id ?>">
                        <div class="row">

                            <!-- First Name -->
                            <div class="col-md-4 mb-3">
                                <label for="first_name" class="form-label">First Name</label>
                                <input type="text" class="form-control" name="first_name"
                                    value="<?= htmlspecialchars($patient['first_name']) ?>" required>
                            </div>

                            <!-- Last Name -->
                            <div class="col-md-4 mb-3">
                                <label for="last_name" class="form-label">Last Name</label>
                                <input type="text" class="form-control" name="last_name"
                                    value="<?= htmlspecialchars($patient['last_name']) ?>" required>
                            </div>

                            <!-- Middle Name -->
                            <div class="col-md-4 mb-3">
                                <label for="middle_name" class="form-label">Middle Name</label>
                                <input type="text" class="form-control" name="middle_name"
                                    value="<?= htmlspecialchars($patient['middle_name']) ?>">
                            </div>

                            <!-- Address -->
                            <div class="col-md-6 mb-3">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" class="form-control" name="address"
                                    value="<?= htmlspecialchars($patient['address']) ?>">
                            </div>

                            <!-- Age -->
                            <div class="col-md-2 mb-3">
                                <label for="age" class="form-label">Age</label>
                                <input type="number" class="form-control" name="age"
                                    value="<?= htmlspecialchars($patient['age']) ?>">
                            </div>

                            <!-- Date of Birth -->
                            <div class="col-md-4 mb-3">
                                <label for="date_of_birth" class="form-label">Date of Birth</label>
                                <input type="date" class="form-control" name="date_of_birth"
                                    value="<?= htmlspecialchars($patient['date_of_birth']) ?>">
                            </div>

                            <!-- Birth Place -->
                            <div class="col-md-4 mb-3">
                                <label for="birth_place" class="form-label">Birth Place</label>
                                <input type="text" class="form-control" name="birth_place"
                                    value="<?= htmlspecialchars($patient['birth_place']) ?>">
                            </div>

                            <!-- Nationality -->
                            <div class="col-md-4 mb-3">
                                <label for="nationality" class="form-label">Nationality</label>
                                <input type="text" class="form-control" name="nationality"
                                    value="<?= htmlspecialchars($patient['nationality']) ?>">
                            </div>

                            <!-- Religion -->
                            <div class="col-md-4 mb-3">
                                <label for="religion" class="form-label">Religion</label>
                                <input type="text" class="form-control" name="religion"
                                    value="<?= htmlspecialchars($patient['religion']) ?>">
                            </div>

                            <!-- Occupation -->
                            <div class="col-md-6 mb-3">
                                <label for="occupation" class="form-label">Occupation</label>
                                <input type="text" class="form-control" name="occupation"
                                    value="<?= htmlspecialchars($patient['occupation']) ?>">
                            </div>

                            <!-- Civil Status -->
                            <div class="col-md-3 mb-3">
                                <label for="civil_status" class="form-label">Civil Status</label>
                                <select class="form-select" name="civil_status">
                                    <option value="Single"
                                        <?= $patient['civil_status'] == 'Single' ? 'selected' : '' ?>>
                                        Single</option>
                                    <option value="Married"
                                        <?= $patient['civil_status'] == 'Married' ? 'selected' : '' ?>>
                                        Married</option>
                                    <option value="Widowed"
                                        <?= $patient['civil_status'] == 'Widowed' ? 'selected' : '' ?>>
                                        Widowed</option>
                                    <option value="Separated"
                                        <?= $patient['civil_status'] == 'Separated' ? 'selected' : '' ?>>
                                        Separated</option>
                                    <option value="Divorced"
                                        <?= $patient['civil_status'] == 'Divorced' ? 'selected' : '' ?>>
                                        Divorced</option>
                                </select>
                            </div>

                            <!-- Gender -->
                            <div class="col-md-3 mb-3">
                                <label for="gender" class="form-label">Gender</label>
                                <select class="form-select" name="gender">
                                    <option value="Male" <?= $patient['gender'] == 'Male' ? 'selected' : '' ?>>Male
                                    </option>
                                    <option value="Female" <?= $patient['gender'] == 'Female' ? 'selected' : '' ?>>
                                        Female</option>
                                    <option value="Other" <?= $patient['gender'] == 'Other' ? 'selected' : '' ?>>
                                        Other</option>
                                </select>
                            </div>

                            <!-- Contact Number -->
                            <div class="col-md-6 mb-3">
                                <label for="contact_number" class="form-label">Contact Number</label>
                                <input type="text" class="form-control" name="contact_number"
                                    value="<?= htmlspecialchars($patient['contact_number']) ?>">
                            </div>

                            <!-- Email Address -->
                            <div class="col-md-6 mb-3">
                                <label for="email_address" class="form-label">Email Address</label>
                                <input type="email" class="form-control" name="email_address"
                                    value="<?= htmlspecialchars($patient['email_address']) ?>">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- OPD Record Modal -->
    <div class="modal fade" id="opdModal" tabindex="-1" aria-labelledby="opdModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-custom text-white">
                    <h5 class="modal-title" id="opdModalLabel">Add Out-Patient Department (OPD) Record</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="saveopd.php" method="POST">
                        <input type="hidden" name="patient_id" value="<?= $patient_id ?>">

                        <div class="row mb-3">
                            <div class="col-sm-6">
                                <!-- Date and Time -->
                                <label class="form-label">Date and Time</label>
                                <input type="datetime-local" class="form-control" name="date_time" required>

                                <!-- Last Name -->
                                <label class="form-label mt-2">Last Name</label>
                                <input type="text" class="form-control" name="last_name" value="<?= htmlspecialchars($patient['last_name'] ?? '') ?>" readonly>

                                <!-- First Name -->
                                <label class="form-label mt-2">First Name</label>
                                <input type="text" class="form-control" name="first_name" value="<?= htmlspecialchars($patient['first_name'] ?? '') ?>" readonly>

                                <!-- Middle Name -->
                                <label class="form-label mt-2">Middle Name</label>
                                <input type="text" class="form-control" name="middle_name" value="<?= htmlspecialchars($patient['middle_name'] ?? '') ?>" readonly>

                                <!-- Birthdate -->
                                <label class="form-label mt-2">Birthdate</label>
                                <input type="date" class="form-control" name="birthdate" value="<?= htmlspecialchars($patient['date_of_birth'] ?? '') ?>" readonly>

                                <!-- Age -->
                                <label class="form-label mt-2">Age</label>
                                <input type="number" class="form-control" name="age" value="<?= htmlspecialchars($patient['age'] ?? '') ?>" readonly>

                                <!-- Sex -->
                                <label class="form-label mt-2">Sex</label>
                                <input type="text" class="form-control" name="sex" value="<?= htmlspecialchars($patient['gender'] ?? '') ?>" readonly>
                            </div>

                            <div class="col-sm-6">
                                <!-- Present Address -->
                                <label class="form-label">Present Address</label>
                                <input type="text" class="form-control" name="address" value="<?= htmlspecialchars($patient['address'] ?? '') ?>" readonly>

                                <!-- Telephone/Cellphone # -->
                                <label class="form-label mt-2">Telephone / Cellphone #</label>
                                <input type="text" class="form-control" name="contact" value="<?= htmlspecialchars($patient['contact_number'] ?? '') ?>" readonly>

                                <!-- Attending Physician -->
                                <label class="form-label mt-2">Attending Physician</label>
                                <input type="text" class="form-control" name="attending_physician" required>

                                <!-- Chief Complaint -->
                                <label class="form-label mt-2">Chief Complaint</label>
                                <input type="text" class="form-control" name="chief_complaint" required>
                            </div>
                        </div>

                        <hr>

                        <div class="row mb-3">
                            <div class="col-sm-2">
                                <label class="form-label">BP</label>
                                <input type="text" class="form-control" name="bp">
                            </div>
                            <div class="col-sm-2">
                                <label class="form-label">PR</label>
                                <input type="text" class="form-control" name="pr">
                            </div>
                            <div class="col-sm-2">
                                <label class="form-label">RR</label>
                                <input type="text" class="form-control" name="rr">
                            </div>
                            <div class="col-sm-2">
                                <label class="form-label">Temp.</label>
                                <input type="text" class="form-control" name="temp">
                            </div>
                            <div class="col-sm-2">
                                <label class="form-label">Weight</label>
                                <input type="text" class="form-control" name="weight">
                            </div>
                            <div class="col-sm-2">
                                <label class="form-label">Height</label>
                                <input type="text" class="form-control" name="height">
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Save Record</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Admission & Discharge Modal -->
    <div class="modal fade" id="admissionModal" tabindex="-1" aria-labelledby="admissionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-custom text-white">
                    <h5 class="modal-title" id="admissionModalLabel">Edit Admission and Discharge Record</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="staff_saveadmission.php" method="POST">
                        <input type="hidden" name="patient_id" value="<?= $patient_id ?>">

                        <div class="row mb-3">
                            <div class="col-sm-6">
                                <!-- Admitting Personnel -->
                                <label class="form-label">Admitting Personnel</label>
                                <input type="text" class="form-control" name="admitting_personnel"
                                    value="<?= htmlspecialchars($admission['admitting_personnel'] ?? '') ?>">

                                <!-- Admission Date and Time -->
                                <label class="form-label mt-2">Admission Date & Time</label>
                                <input type="datetime-local" class="form-control" name="admission_datetime"
                                    value="<?= htmlspecialchars($admission['admission_datetime'] ?? '') ?>">

                                <!-- Type of Admission -->
                                <label class="form-label mt-2">Type of Admission</label>
                                <select class="form-select" name="admission_type">
                                  <option value="New" <?= isset($admission['admission_type']) && $admission['admission_type'] == 'New' ? 'Selected' : '' ?>>
                                      New</option>
                                  <option value="Old" <?= isset($admission['admission_type']) && $admission['admission_type'] == 'Old' ? 'Selected' : '' ?>>
                                      Old</option>
                                </select>

                                <!-- Referred By -->
                                <label class="form-label mt-2">Referred By</label>
                                <input type="text" class="form-control" name="referred_by"
                                    value="<?= htmlspecialchars($admission['referred_by'] ?? 'Not specified') ?>">
                            </div>

                            <div class="col-sm-6">
                                <!-- Attending Physician -->
                                <label class="form-label">Attending Physician</label>
                                <input type="text" class="form-control" name="attending_physician"
                                    value="<?= htmlspecialchars($admission['attending_physician'] ?? '') ?>">

                                <!-- Discharge Date and Time -->
                                <label class="form-label mt-2">Discharge Date & Time</label>
                                <input type="datetime-local" class="form-control" name="discharge_datetime"
                                    value="<?= htmlspecialchars($admission['discharge_datetime'] ?? '') ?>">

                                <!-- Total No. Of Days -->
                                <label class="form-label mt-2">Total No. of Days</label>
                                <input type="number" class="form-control" name="total_days"
                                    value="<?= htmlspecialchars($admission['total_days'] ?? '') ?>">

                                <!-- Ward or Services -->
                                <label class="form-label mt-2">Ward / Services</label>
                                <input type="text" class="form-control" name="ward_services"
                                    value="<?= htmlspecialchars($admission['ward_services'] ?? '') ?>">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-6">
                                <!-- Insurance or Benefits -->
                                <label class="form-label">Health Insurance / Benefits</label>
                                <select class="form-select" name="insurance">
                                    <option value="None">None</option>
                                    <option value="Indigent">Indigent</option>
                                    <option value="PWD">PWD</option>
                                    <option value="Non-indigent">Non-indigent</option>
                                    <option value="Pink Card Holder">Pink Card Holder</option>
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <!-- Allergic To -->
                                <label class="form-label">Allergic To</label>
                                <input type="text" class="form-control" name="allergic_to"
                                    value="<?= htmlspecialchars($admission['allergic_to'] ?? '') ?>">
                            </div>
                        </div>

                        <hr>

                        <!-- Admission Diagnosis -->
                        <label class="form-label">Admission Diagnosis</label>
                        <input type="text" class="form-control mb-2" name="admission_diagnosis"
                            value="<?= htmlspecialchars($admission['admission_diagnosis'] ?? '') ?>">

                        <!-- Final Diagnosis -->
                        <label class="form-label">Final Diagnosis</label>
                        <input type="text" class="form-control mb-2" name="final_diagnosis"
                            value="<?= htmlspecialchars($admission['final_diagnosis'] ?? '') ?>">

                        <hr>

                        <!-- Procedure -->
                        <label class="form-label">Principal Operation / Procedure</label>
                        <input type="text" class="form-control mb-2" name="procedre"
                            value="<?= htmlspecialchars($admission['procedre'] ?? '') ?>">

                        <!-- Other Procedures -->
                        <label class="form-label">Other Procedures</label>
                        <input type="text" class="form-control mb-2" name="other_procedures"
                            value="<?= htmlspecialchars($admission['other_procedures'] ?? '') ?>">

                        <!-- Injury Code -->
                        <label class="form-label">Accident/Injury/Poisoning Code</label>
                        <input type="text" class="form-control mb-3" name="injury_code"
                            value="<?= htmlspecialchars($admission['injury_code'] ?? '') ?>">

                        <div class="row mb-3">
                            <div class="col-sm-6">
                                <!-- Place of Occurrence -->
                                <label class="form-label">Place of Occurrence</label>
                                <input type="text" class="form-control" name="place_occurrence"
                                    value="<?= htmlspecialchars($admission['place_occurrence'] ?? '') ?>">

                                <!-- Disposition -->
                                <label class="form-label mt-2">Disposition</label>
                                <select class="form-select" name="disposition">
                                    <option value="Discharge">Discharged</option>
                                    <option value="Transferred">Transferred</option>
                                    <option value="HAMA">HAMA</option>
                                    <option value="Absconded">Absconded</option>
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <!-- Outcome -->
                                <label class="form-label">Outcome</label>
                                <input type="text" class="form-control" name="outcome"
                                    value="<?= htmlspecialchars($admission['outcome'] ?? '')  ?>">

                                <!-- Autopsy -->
                                <label class="form-label mt-2">Autopsy</label>
                                <select class="form-select" name="autopsy">
                                    <option value="No">No Autopsy</option>
                                    <option value="Yes">Autopsy</option>
                                </select>
                            </div>
                        </div>

                        <hr>

                        <div class="row mb-3">
                            <div class="col-sm-4">
                                <!-- Data Furnished By -->
                                <label class="form-label">Data Furnished By</label>
                                <input type="text" class="form-control" name="informant_name"
                                  value="<?= isset($admission['informant_name']) ? htmlspecialchars($admission['informant_name']) : '' ?>"
                                >
                            </div>

                            <div class="col-sm-4">
                                <!-- Relation to Patient -->
                                <label class="form-label">Relation to Patient</label>
                                <input type="text" class="form-control" name="relation"
                                    value="<?= isset($admission['relation']) ? htmlspecialchars($admission['relation'])  : '' ?>">
                            </div>

                            <div class="col-sm-4">
                                <!-- Informant Address and Contact -->
                                <label class="form-label">Informant Address & Contact</label>
                                <input type="text" class="form-control" name="informant_contact"
                                    value="<?= isset($admission['informant_contact']) ? htmlspecialchars($admission['informant_contact'])  : '' ?>">
                            </div>

                            <div class="col-sm-6">
                                <!-- Physician's Signature -->
                                <label class="form-label mt-2">Physician</label>
                                <input type="text" class="form-control" name="physician_signature"
                                    value="<?= isset($admission['physician_signature']) ? htmlspecialchars($admission['physician_signature'])  : '' ?>">
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Save
                                Record</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


    <?php if ($showEditModal): ?>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var editModal = new bootstrap.Modal(document.getElementById('editPatientModal'));
        editModal.show();
    });
    </script>
    <?php endif; ?>


</body>

</html>