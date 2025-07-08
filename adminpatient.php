<?php

// adminpatient.php (patient list)

session_start();
if (!isset($_SESSION["username"])) {
    header("Location: loginpage.php");
    exit();
}

require_once "dbconn.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Patient Records</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            overflow-x: hidden;
            background-color: #f2f2f2;
        }

        /* Navbar styling */
        .bg-custom {
            background-color: #3498db !important;
        }

        /* Sidebar styling */
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
            /* leaves space for navbar */
        }

        .bg-patient-header {
            background-color: rgb(58, 148, 208) !important;
            /* A green shade; change to any color you like */
            color: white;
        }

        .table thead {
            background-color: rgb(58, 148, 208);
            color: white;
        }

        .search-box {
            max-width: 300px;
        }

        /* Show dropdown on hover */
        .content-dropdown:hover .dropdown-menu {
            display: block;
            margin-top: 0;
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

    <?php include 'sidebar.php'; ?>

    <?php if (isset($_GET['status'])): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                <?php if ($_GET['status'] === 'added'): ?>
                    Swal.fire({
                        icon: 'success',
                        title: 'Patient Added',
                        text: 'The patient record has been successfully added.',
                        timer: 2000,
                        showConfirmButton: false
                    });
                <?php elseif ($_GET['status'] === 'updated'): ?>
                    Swal.fire({
                        icon: 'success',
                        title: 'Patient Updated',
                        text: 'The patient record has been successfully updated.',
                        timer: 2000,
                        showConfirmButton: false
                    });
                <?php elseif ($_GET['status'] === 'archived'): ?>
                    Swal.fire({
                        icon: 'success',
                        title: 'Patient Archived',
                        text: 'The patient has been successfully archived.',
                        timer: 2000,
                        showConfirmButton: false
                    });
                <?php endif; ?>
            });
        </script>
    <?php endif; ?>

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid mt-4">
            <div class="card shadow-sm border-0">

                <!-- Table Title -->
                <div
                    class="card-header bg-patient-header text-white d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <h4 class="mb-0">Patient Records</h4>
                    <div class="d-flex gap-2">
                        <input type="text" class="form-control search-box" id="searchInput"
                            placeholder="Search patients...">
                        <a href="#" class="btn btn-light text-dark" data-bs-toggle="modal"
                            data-bs-target="#addPatientModal">
                            <i class="bi bi-person-plus-fill me-1"></i>
                        </a>
                    </div>
                </div>

                <!-- Table -->
                <div class="card-body table-responsive">
                    <table class="table table-hover table-bordered align-middle" id="patientTable">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Last Name</th>
                                <th>First Name</th>
                                <th>Middle Name</th>
                                <th>Gender</th>
                                <th>Birthdate</th>
                                <th>Age</th>
                                <th>Contact No.</th>
                                <th>Email Address</th>
                                <th>Date Admitted</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $result = $conn->query("SELECT * FROM patients");
                            $count = 1;

                            while ($row = $result->fetch_assoc()) {
                                echo "<tr >";
                                echo "<td patient_id=" . $row['patient_id'] . "'\" >" . $count++ . "</td>";
                                echo "<td patient_id=" . $row['patient_id'] . "'\" >" . htmlspecialchars($row['last_name']) . "</td>";
                                echo "<td patient_id=" . $row['patient_id'] . "'\" >" . htmlspecialchars($row['first_name']) . "</td>";
                                echo "<td patient_id=" . $row['patient_id'] . "'\" >" . htmlspecialchars($row['middle_name']) . "</td>";
                                echo "<td patient_id=" . $row['patient_id'] . "'\" >" . htmlspecialchars($row['gender']) . "</td>";
                                echo "<td patient_id=" . $row['patient_id'] . "'\" >" . htmlspecialchars($row['date_of_birth']) . "</td>";
                                echo "<td patient_id=" . $row['patient_id'] . "'\" >" . htmlspecialchars($row['age']) . "</td>";
                                echo "<td patient_id=" . $row['patient_id'] . "'\" >" . htmlspecialchars($row['contact_number']) . "</td>";
                                echo "<td patient_id=" . $row['patient_id'] . "'\" >" . htmlspecialchars($row['email_address']) . "</td>";
                                echo "<td patient_id=" . $row['patient_id'] . "'\" >" . htmlspecialchars($row['created_at']) . "</td>";
                                echo '<td>

                            <a href="#" class="btn btn-sm btn-secondary view-btn"
                                data-bs-toggle="modal"
                                data-bs-target="#viewPatientModal"
                                data-fullname="' . htmlspecialchars($row['last_name'] . ', ' . $row['first_name'] . ' ' . $row['middle_name']) . '"
                                data-gender="' . htmlspecialchars($row['gender']) . '"
                                data-birthdate="' . htmlspecialchars($row['date_of_birth']) . '"
                                data-age="' . htmlspecialchars($row['age']) . '"
                                data-contact="' . htmlspecialchars($row['contact_number']) . '"
                                data-email="' . htmlspecialchars($row['email_address']) . '"
                                data-created="' . htmlspecialchars($row['created_at']) . '"
                                data-address="' . htmlspecialchars($row['address']) . '"
                                data-birthplace="' . htmlspecialchars($row['birth_place']) . '"
                                data-nationality="' . htmlspecialchars($row['nationality']) . '"
                                data-religion="' . htmlspecialchars($row['religion']) . '"
                                data-occupation="' . htmlspecialchars($row['occupation']) . '"
                                data-civilstatus="' . htmlspecialchars($row['civil_status']) . '">
                                <i class="bi bi-eye-fill"></i>
                            </a>

                            <button type="button"
                                class="btn btn-sm btn-warning text-white edit-btn"
                                data-bs-toggle="modal"
                                data-bs-target="#editPatientModal"
                                data-patient-id="' . htmlspecialchars($row['patient_id']) . '"
                                data-first-name="' . htmlspecialchars($row['first_name']) . '"
                                data-last-name="' . htmlspecialchars($row['last_name']) . '"
                                data-middle-name="' . htmlspecialchars($row['middle_name']) . '"
                                data-address="' . htmlspecialchars($row['address']) . '"
                                data-age="' . htmlspecialchars($row['age']) . '"
                                data-date-of-birth="' . htmlspecialchars($row['date_of_birth']) . '"
                                data-birth-place="' . htmlspecialchars($row['birth_place']) . '"
                                data-nationality="' . htmlspecialchars($row['nationality']) . '"
                                data-religion="' . htmlspecialchars($row['religion']) . '"
                                data-occupation="' . htmlspecialchars($row['occupation']) . '"
                                data-civil-status="' . htmlspecialchars($row['civil_status']) . '"
                                data-gender="' . htmlspecialchars($row['gender']) . '"
                                data-contact-number="' . htmlspecialchars($row['contact_number']) . '"
                                data-email-address="' . htmlspecialchars($row['email_address']) . '">
                                <i class="bi bi-pencil"></i>
                            </button>

                            <button 
                                type="button"
                                class="btn btn-sm btn-secondary"
                                data-bs-toggle="modal" 
                                data-bs-target="#archiveModal" 
                                onclick="document.getElementById(\'archivePatientId\').value = ' . $row['patient_id'] . '">
                                <i class="bi bi-archive"></i>
                            </button>
                        </td>';

                                echo "</tr>";
                            }
                            ?>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>


    <!-- Add Patient Modal -->
    <div class="modal fade" id="addPatientModal" tabindex="-1" aria-labelledby="addPatientModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="savepatient.php" method="POST">
                    <div class="modal-header bg-custom text-white">
                        <h5 class="modal-title" id="addPatientModalLabel">Add New Patient</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>

                    <div class="modal-body row g-3">
                        <!-- Form Fields (adjust IDs/names as needed) -->
                        <div class="col-md-4">
                            <label for="first_name" class="form-label">First Name*</label>
                            <input type="text" class="form-control" name="first_name" required>
                        </div>

                        <div class="col-md-4">
                            <label for="last_name" class="form-label">Last Name*</label>
                            <input type="text" class="form-control" name="last_name" required>
                        </div>

                        <div class="col-md-4">
                            <label for="middle_name" class="form-label">Middle Name</label>
                            <input type="text" class="form-control" name="middle_name">
                        </div>

                        <div class="col-md-6">
                            <label for="address" class="form-label">Address*</label>
                            <textarea type="text" class="form-control" name="address" rows="2" required></textarea>
                        </div>

                        <div class="col-md-3">
                            <label for="date_of_birth" class="form-label">Date of Birth*</label>
                            <input type="date" class="form-control" name="date_of_birth" required>
                        </div>

                        <div class="col-md-3">
                            <label for="birth_place" class="form-label">Birth Place</label>
                            <textarea type="text" class="form-control" name="birth_place" rows="2"></textarea>
                        </div>

                        <div class="col-md-3">
                            <label for="civil_status" class="form-label">Civil Status*</label>
                            <select class="form-select" name="civil_status">
                                <option value="Single">Single</option>
                                <option value="Married">Married</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label for="gender" class="form-label">Gender*</label>
                            <select class="form-select" name="gender">
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label for="contact_number" class="form-label">Contact Number*</label>
                            <input type="text" class="form-control" name="contact_number" required>
                        </div>

                        <div class="col-md-3">
                            <label for="email_address" class="form-label">Email</label>
                            <input type="email" class="form-control" name="email_address">
                        </div>

                        <div class="col-md-3">
                            <label for="nationality" class="form-label">Nationality</label>
                            <input type="text" class="form-control" name="nationality">
                        </div>

                        <div class="col-md-3">
                            <label for="religion" class="form-label">Religion</label>
                            <input type="text" class="form-control" name="religion">
                        </div>

                        <div class="col-md-6">
                            <label for="occupation" class="form-label">Occupation</label>
                            <input type="text" class="form-control" name="occupation">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Save Patient</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


    <!-- Search Name and ID... -->
    <script>
        // Store original HTML content on page load
        const rowMap = new Map();

        document.querySelectorAll('#patientTable tbody tr').forEach((row, index) => {
            rowMap.set(index, row.innerHTML); // Save original row content
        });

        document.getElementById('searchInput').addEventListener('input', function () {
            const filter = this.value.toLowerCase().trim();
            const rows = document.querySelectorAll('#patientTable tbody tr');

            rows.forEach((row, index) => {
                // Reset row content before re-highlighting
                row.innerHTML = rowMap.get(index);

                const rowText = row.innerText.toLowerCase();
                const matchFound = rowText.includes(filter);

                row.style.display = matchFound ? '' : 'none';

                // Highlight matching text except in Actions column (last cell)
                if (matchFound && filter) {
                    Array.from(row.cells).forEach((cell, i) => {
                        // Don't highlight the Actions column (last column)
                        if (i === row.cells.length - 1) return;

                        const originalText = cell.textContent;
                        const regex = new RegExp(`(${filter})`, 'gi');
                        cell.innerHTML = originalText.replace(regex, '<mark>$1</mark>');
                    });
                }
            });
        });
    </script>


    <!-- Archive Confirmation Modal -->
    <div class="modal fade" id="archiveModal" tabindex="-1" aria-labelledby="archiveModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form method="POST" action="deletepatient.php">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title" id="archiveModalLabel">Confirm Archive</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to archive this patient?
                        <input type="hidden" name="patient_id" id="archivePatientId">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Archive</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Patient Modal -->
    <div class="modal fade" id="editPatientModal" tabindex="-1" aria-labelledby="editPatientModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="savepatient.php" method="post">
                    <div class="modal-header bg-custom text-white">
                        <h5 class="modal-title" id="editPatientModalLabel">Edit Patient Information</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="patient_id" id="editPatientId">
                        <div class="row">

                            <!-- First Name -->
                            <div class="col-md-4 mb-3">
                                <label for="first_name" class="form-label">First Name*</label>
                                <input type="text" class="form-control" name="first_name" id="editFirstName" required>
                            </div>

                            <!-- Last Name -->
                            <div class="col-md-4 mb-3">
                                <label for="last_name" class="form-label">Last Name*</label>
                                <input type="text" class="form-control" name="last_name" id="editLastName" required>
                            </div>

                            <!-- Middle Name -->
                            <div class="col-md-4 mb-3">
                                <label for="middle_name" class="form-label">Middle Name</label>
                                <input type="text" class="form-control" name="middle_name" id="editMiddleName">
                            </div>

                            <!-- Address -->
                            <div class="col-md-6 mb-3">
                                <label for="address" class="form-label">Address*</label>
                                <textarea class="form-control" name="address" id="editAddress" rows="2" required></textarea>
                            </div>

                            <!-- Age -->
                            <div class="col-md-2 mb-3">
                                <label for="age" class="form-label">Age</label>
                                <input type="number" class="form-control" name="age" id="editAge" readonly>
                            </div>

                            <!-- Date of Birth -->
                            <div class="col-md-4 mb-3">
                                <label for="date_of_birth" class="form-label">Date of Birth*</label>
                                <input type="date" class="form-control" name="date_of_birth" id="editDateOfBirth"
                                    required>
                            </div>

                            <!-- Birth Place -->
                            <div class="col-md-4 mb-3">
                                <label for="birth_place" class="form-label">Birth Place</label>
                                <textarea class="form-control" name="birth_place" id="editBirthPlace"
                                    rows="2"></textarea>
                            </div>

                            <!-- Nationality -->
                            <div class="col-md-4 mb-3">
                                <label for="nationality" class="form-label">Nationality</label>
                                <input type="text" class="form-control" name="nationality" id="editNationality">
                            </div>

                            <!-- Religion -->
                            <div class="col-md-4 mb-3">
                                <label for="religion" class="form-label">Religion</label>
                                <input type="text" class="form-control" name="religion" id="editReligion">
                            </div>

                            <!-- Occupation -->
                            <div class="col-md-6 mb-3">
                                <label for="occupation" class="form-label">Occupation</label>
                                <input type="text" class="form-control" name="occupation" id="editOccupation">
                            </div>

                            <!-- Civil Status -->
                            <div class="col-md-3 mb-3">
                                <label for="civil_status" class="form-label">Civil Status*</label>
                                <select class="form-select" name="civil_status">
                                    <option id="editCivilStatus">
                                        Single</option>
                                    <option id="editCivilStatus">
                                        Married</option>
                                </select>
                            </div>

                            <!-- Gender -->
                            <div class="col-md-3 mb-3">
                                <label for="gender" class="form-label">Gender*</label>
                                <select class="form-select" name="gender">
                                    <option id="editGender">Male
                                    </option>
                                    <option id="editGender">
                                        Female</option>
                                </select>
                            </div>

                            <!-- Contact Number -->
                            <div class="col-md-6 mb-3">
                                <label for="contact_number" class="form-label">Contact Number*</label>
                                <input type="text" class="form-control" name="contact_number" id="editContactNumber" required>
                            </div>

                            <!-- Email Address -->
                            <div class="col-md-6 mb-3">
                                <label for="email_address" class="form-label">Email Address</label>
                                <input type="email" class="form-control" name="email_address" id="editEmailAddress">
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

    <!-- View Patient Modal -->
    <div class="modal fade" id="viewPatientModal" tabindex="-1" aria-labelledby="viewPatientModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg"> <!-- Large size for more content -->
            <div class="modal-content">
                <div class="modal-header bg-custom text-white fw-bold">
                    <h5 class="modal-title" id="viewPatientModalLabel">Patient Details</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <!-- Each field styled like User Modal -->
                    <div class="mb-3">
                        <label class="form-label">Full Name:</label>
                        <p class="fw-bold mb-0" id="viewFullname"></p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Gender:</label>
                        <p class="fw-bold mb-0" id="viewGender"></p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Birthdate:</label>
                        <p class="fw-bold mb-0" id="viewBirthdate"></p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Age:</label>
                        <p class="fw-bold mb-0" id="viewAge"></p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Contact Number:</label>
                        <p class="fw-bold mb-0" id="viewContact"></p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email:</label>
                        <p class="fw-bold mb-0" id="viewEmail"></p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Address:</label>
                        <p class="fw-bold mb-0" id="viewAddress" style="white-space: pre-wrap;"></p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Birth Place:</label>
                        <p class="fw-bold mb-0" id="viewBirthPlace" style="white-space: pre-wrap;"></p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nationality:</label>
                        <p class="fw-bold mb-0" id="viewNationality"></p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Religion:</label>
                        <p class="fw-bold mb-0" id="viewReligion"></p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Occupation:</label>
                        <p class="fw-bold mb-0" id="viewOccupation"></p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Civil Status:</label>
                        <p class="fw-bold mb-0" id="viewCivilStatus"></p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Date Admitted:</label>
                        <p class="fw-bold mb-0" id="viewCreated"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--
    <script>
    const searchInput = document.getElementById("searchInput");
    const tableRows = document.querySelectorAll("#patientTable tr");

    searchInput.addEventListener("keyup", function() {
        const query = this.value.toLowerCase();
        tableRows.forEach(row => {
            const rowText = row.innerText.toLowerCase();
            row.style.display = rowText.includes(query) ? "" : "none";
        });
    });
    </script>
    -->

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.view-btn').forEach(button => {
                button.addEventListener('click', function () {
                    document.getElementById('viewFullname').textContent = this.getAttribute('data-fullname');
                    document.getElementById('viewGender').textContent = this.getAttribute('data-gender');
                    document.getElementById('viewBirthdate').textContent = this.getAttribute('data-birthdate');
                    document.getElementById('viewAge').textContent = this.getAttribute('data-age');
                    document.getElementById('viewContact').textContent = this.getAttribute('data-contact');
                    document.getElementById('viewEmail').textContent = this.getAttribute('data-email');
                    document.getElementById('viewAddress').textContent = this.getAttribute('data-address');
                    document.getElementById('viewBirthPlace').textContent = this.getAttribute('data-birthplace');
                    document.getElementById('viewNationality').textContent = this.getAttribute('data-nationality');
                    document.getElementById('viewReligion').textContent = this.getAttribute('data-religion');
                    document.getElementById('viewOccupation').textContent = this.getAttribute('data-occupation');
                    document.getElementById('viewCivilStatus').textContent = this.getAttribute('data-civilstatus');
                    document.getElementById('viewCreated').textContent = this.getAttribute('data-created');
                });
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.edit-btn').forEach(button => {
                button.addEventListener('click', function () {
                    document.getElementById('editPatientId').value = this.getAttribute('data-patient-id');
                    document.getElementById('editFirstName').value = this.getAttribute('data-first-name');
                    document.getElementById('editLastName').value = this.getAttribute('data-last-name');
                    document.getElementById('editMiddleName').value = this.getAttribute('data-middle-name');
                    document.getElementById('editAddress').value = this.getAttribute('data-address');
                    document.getElementById('editAge').value = this.getAttribute('data-age');
                    document.getElementById('editDateOfBirth').value = this.getAttribute('data-date-of-birth');
                    document.getElementById('editBirthPlace').value = this.getAttribute('data-birth-place');
                    document.getElementById('editNationality').value = this.getAttribute('data-nationality');
                    document.getElementById('editReligion').value = this.getAttribute('data-religion');
                    document.getElementById('editOccupation').value = this.getAttribute('data-occupation');
                    document.getElementById('editCivilStatus').value = this.getAttribute('data-civil-status');
                    document.getElementById('editGender').value = this.getAttribute('data-gender');
                    document.getElementById('editContactNumber').value = this.getAttribute('data-contact-number');
                    document.getElementById('editEmailAddress').value = this.getAttribute('data-email-address');
                });
            });
        });
    </script>

    <!-- addPatientModal.viewpatient -->
    <?php if (isset($_GET['add']) && $_GET['add'] == 'true'): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var addPatientModal = new bootstrap.Modal(document.getElementById('addPatientModal'));
                addPatientModal.show();
            });
        </script>
    <?php endif; ?>
</body>

</html>