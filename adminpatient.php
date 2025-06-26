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
</head>

<body>

    <?php include 'sidebar.php'; ?>

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
                    <table class="table table-hover table-bordered align-middle">
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
                        <tbody id="patientTable">
                            <?php
                $result = $conn->query("SELECT * FROM patients");
                $count = 1;
                
                while ($row = $result->fetch_assoc()) {
                    echo "<tr >";
                    echo "<td onclick=\"window.location='viewpatient.php?patient_id=" . $row['patient_id'] . "'\" style=\"cursor:pointer;\">" . $count++ . "</td>";
                    echo "<td onclick=\"window.location='viewpatient.php?patient_id=" . $row['patient_id'] . "'\" style=\"cursor:pointer;\">" . htmlspecialchars($row['last_name']) . "</td>";
                    echo "<td onclick=\"window.location='viewpatient.php?patient_id=" . $row['patient_id'] . "'\" style=\"cursor:pointer;\">" . htmlspecialchars($row['first_name']) . "</td>";
                    echo "<td onclick=\"window.location='viewpatient.php?patient_id=" . $row['patient_id'] . "'\" style=\"cursor:pointer;\">" . htmlspecialchars($row['middle_name']) . "</td>";
                    echo "<td onclick=\"window.location='viewpatient.php?patient_id=" . $row['patient_id'] . "'\" style=\"cursor:pointer;\">" . htmlspecialchars($row['gender']) . "</td>";
                    echo "<td onclick=\"window.location='viewpatient.php?patient_id=" . $row['patient_id'] . "'\" style=\"cursor:pointer;\">" . htmlspecialchars($row['date_of_birth']) . "</td>";
                    echo "<td onclick=\"window.location='viewpatient.php?patient_id=" . $row['patient_id'] . "'\" style=\"cursor:pointer;\">" . htmlspecialchars($row['age']) . "</td>";
                    echo "<td onclick=\"window.location='viewpatient.php?patient_id=" . $row['patient_id'] . "'\" style=\"cursor:pointer;\">" . htmlspecialchars($row['contact_number']) . "</td>";
                    echo "<td onclick=\"window.location='viewpatient.php?patient_id=" . $row['patient_id'] . "'\" style=\"cursor:pointer;\">" . htmlspecialchars($row['email_address']) . "</td>";
                    echo "<td onclick=\"window.location='viewpatient.php?patient_id=" . $row['patient_id'] . "'\" style=\"cursor:pointer;\">" . htmlspecialchars($row['created_at']) . "</td>";
                    echo '<td>
                            <a href="viewpatient.php?patient_id=' . $row['patient_id'] . '&edit=true" class="btn btn-sm btn-warning text-white">
                                <i class="bi bi-pencil"></i>
                            </a>
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
                            <label for="first_name" class="form-label">First Name</label>
                            <input type="text" class="form-control" name="first_name" required>
                        </div>

                        <div class="col-md-4">
                            <label for="last_name" class="form-label">Last Name</label>
                            <input type="text" class="form-control" name="last_name" required>
                        </div>

                        <div class="col-md-4">
                            <label for="middle_name" class="form-label">Middle Name</label>
                            <input type="text" class="form-control" name="middle_name">
                        </div>

                        <div class="col-md-6">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control" name="address">
                        </div>

                        <div class="col-md-3">
                            <label for="date_of_birth" class="form-label">Date of Birth</label>
                            <input type="date" class="form-control" name="date_of_birth" required>
                        </div>

                        <div class="col-md-3">
                            <label for="birth_place" class="form-label">Birth Place</label>
                            <input type="text" class="form-control" name="birth_place">
                        </div>

                        <div class="col-md-3">
                            <label for="civil_status" class="form-label">Civil Status</label>
                            <select class="form-select" name="civil_status">
                                <option value="Single">Single</option>
                                <option value="Married">Married</option>
                                <option value="Widowed">Widowed</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label for="gender" class="form-label">Gender</label>
                            <select class="form-select" name="gender">
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label for="contact_number" class="form-label">Contact Number</label>
                            <input type="text" class="form-control" name="contact_number">
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


    <!-- Search Name and ID only -->
    <script>
    document.getElementById('searchInput').addEventListener('input', function() {
        const filter = this.value.toLowerCase();
        const rows = document.querySelectorAll('#patientTable tr');

        rows.forEach(row => {
            // Skip header row
            if (row.querySelector('th')) return;

            const idCell = row.cells[0];
            const lastNameCell = row.cells[1];
            const firstNameCell = row.cells[2];

            const idText = idCell?.textContent.toLowerCase() || '';
            const lastNameText = lastNameCell?.textContent.toLowerCase() || '';
            const firstNameText = firstNameCell?.textContent.toLowerCase() || '';

            const matchFound = idText.includes(filter) || lastNameText.includes(filter) || firstNameText
                .includes(filter);

            if (matchFound) {
                row.style.display = '';

                // Highlight matches
                [idCell, lastNameCell, firstNameCell].forEach(cell => {
                    const originalText = cell.textContent;
                    const regex = new RegExp(`(${filter})`, 'gi');
                    cell.innerHTML = originalText.replace(regex, `<mark>$1</mark>`);
                });
            } else {
                row.style.display = 'none';
            }

            // Clear previous highlights if input is empty
            if (!filter) {
                [idCell, lastNameCell, firstNameCell].forEach(cell => {
                    cell.innerHTML = cell.textContent;
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
                        <button type="submit" class="btn btn-danger">Yes, Archive</button>
                    </div>
                </div>
            </form>
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