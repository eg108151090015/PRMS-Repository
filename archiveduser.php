<?php

// archivedpatient.php

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
    .patient-dropdown:hover .dropdown-menu {
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
                    <h4 class="mb-0">Deactivated User Records</h4>
                    <div class="d-flex gap-2">
                        <input type="text" class="form-control search-box" id="searchInput"
                            placeholder="Search users...">
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
                                <th>Role</th>
                                <th>Deactivated At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="userTable">
                            <?php
                              $result = $conn->query("SELECT * FROM archived_users");
                              $count = 1;
                              
                              while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $count++ . "</td>";
                                echo "<td>" . htmlspecialchars($row['lastname']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['firstname']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['middlename']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['role']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['archived_at']) . "</td>";
                        
                                // Restore button with modal trigger
                                echo '<td>
                                        <button class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#restoreModal' . $row['user_id'] . '">
                                            <i class="bi bi-toggle-off"></i>
                                        </button>
                                      </td>';
                                echo "</tr>";

                                // Bootstrap modal per row
                                echo '
                                <div class="modal fade" id="restoreModal' . $row['user_id'] . '" tabindex="-1" aria-labelledby="restoreModalLabel' . $row['user_id'] . '" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header bg-custom text-white">
                                                <h5 class="modal-title" id="restoreModalLabel' . $row['user_id'] . '">Confirm Restore</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>

                                            <div class="modal-body">
                                                Are you sure you want to activate <strong>' . htmlspecialchars($row['firstname']) . ' ' . htmlspecialchars($row['lastname']) . '</strong>?
                                            </div>
                        
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <a href="restoreuser.php?user_id=' . $row['user_id'] . '" class="btn btn-success">Activate</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>';
                              }             
                            ?>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
    const searchInput = document.getElementById("searchInput");
    const tableRows = document.querySelectorAll("#userTable tr");

    searchInput.addEventListener("keyup", function() {
        const query = this.value.toLowerCase();
        tableRows.forEach(row => {
            const rowText = row.innerText.toLowerCase();
            row.style.display = rowText.includes(query) ? "" : "none";
        });
    });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>