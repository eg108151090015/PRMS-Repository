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

    <?php include 'main_content_view_record.php'; ?>

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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="buttons.js"></script>

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