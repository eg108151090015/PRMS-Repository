<?php

// adminuser.php (user list)

session_start();
if (!isset($_SESSION["username"])) {
    header("Location: loginpage.php");
    exit();
}

// Echo the name

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

        .bg-user-header {
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
                        title: 'User Added',
                        text: 'A new user has been successfully added.',
                        timer: 2000,
                        showConfirmButton: false
                    });
                <?php elseif ($_GET['status'] === 'updated'): ?>
                    Swal.fire({
                        icon: 'success',
                        title: 'User Updated',
                        text: 'The user information has been successfully updated.',
                        timer: 2000,
                        showConfirmButton: false
                    });
                <?php elseif ($_GET['status'] === 'deactivated'): ?>
                    Swal.fire({
                        icon: 'success',
                        title: 'User Deactivated',
                        text: 'The user has been successfully deactivated.',
                        timer: 2000,
                        showConfirmButton: false
                    });
                <?php elseif ($_GET['status'] === 'duplicate'): ?>
                    Swal.fire({
                        icon: 'error',
                        title: 'Duplicate Username',
                        text: 'That username already exists. Please try another.',
                        timer: 2500,
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
                    class="card-header bg-user-header text-white d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <h4 class="mb-0">Users</h4>
                    <div class="d-flex gap-2">
                        <input type="text" class="form-control search-box" id="searchInput"
                            placeholder="Search users...">
                        <a href="#" class="btn btn-light text-dark" data-bs-toggle="modal"
                            data-bs-target="#addUserModal">
                            <i class="bi bi-person-plus-fill me-1"></i>
                        </a>
                    </div>
                </div>

                <!-- Table -->
                <div class="card-body table-responsive">
                    <table class="table table-hover table-bordered align-middle" id="userTable">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Last Name</th>
                                <th>First Name</th>
                                <th>Middle Name</th>
                                <th>Role</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $result = $conn->query("SELECT * FROM users WHERE status = 'active'");
                            $count = 1;

                            while ($row = $result->fetch_assoc()) {
                                echo "<tr >";
                                echo "<td>" . $count++ . "</td>";
                                echo "<td>" . htmlspecialchars($row['lastname']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['firstname']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['middlename']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['role']) . "</td>";
                                echo '<td align="center">
                                            <a href="#" 
                                                class="btn btn-sm btn-secondary" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#viewUserModal"
                                                data-fullname="' . htmlspecialchars($row['lastname'] . ', ' . $row['firstname'] . ' ' . $row['middlename']) . '"
                                                data-role= ' . htmlspecialchars($row['role']) . '
                                                data-username= ' . htmlspecialchars($row['username']) . '
                                                data-password= ' . htmlspecialchars($row['password']) . '>
                                                    <i class="bi bi-eye-fill"></i>
                                            </a>
                                            <button 
                                                type="button"
                                                class="btn btn-sm btn-warning"
                                                data-bs-toggle="modal" 
                                                data-bs-target="#editUserModal"
                                                data-user_id="' . $row['user_id'] . '"
                                                data-firstname="' . htmlspecialchars($row['firstname']) . '"
                                                data-lastname="' . htmlspecialchars($row['lastname']) . '"
                                                data-middlename="' . htmlspecialchars($row['middlename']) . '"
                                                data-role=' . htmlspecialchars($row['role']) . '
                                                data-username="' . htmlspecialchars($row['username']) . '">
                                                    <i class="bi bi-pencil text-white"></i>
                                            </button>
                                            <button 
                                                type="button"
                                                class="btn btn-sm btn-success"
                                                data-bs-toggle="modal" 
                                                data-bs-target="#archiveModal" 
                                                onclick="document.getElementById(\'archiveUserId\').value = ' . $row['user_id'] . '">
                                                <i class="bi bi-toggle-on"></i>
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


    <!-- Add User Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="saveuser.php" method="POST">
                    <div class="modal-header bg-custom text-white">
                        <h5 class="modal-title" id="addUserModalLabel">Add New User</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>

                    <div class="modal-body row g-3">
                        <!-- Form Fields (adjust IDs/names as needed) -->

                        <!-- First Name -->
                        <div class="col-md-4">
                            <label for="firstname" class="form-label">First Name*</label>
                            <input type="text" class="form-control" name="firstname" required>
                        </div>

                        <!-- Last Name -->
                        <div class="col-md-4">
                            <label for="lastname" class="form-label">Last Name*</label>
                            <input type="text" class="form-control" name="lastname" required>
                        </div>

                        <!-- Middle Name -->
                        <div class="col-md-4">
                            <label for="middlename" class="form-label">Middle Name</label>
                            <input type="text" class="form-control" name="middlename">
                        </div>

                        <!-- Username -->
                        <div class="col-md-6">
                            <label for="username" class="form-label">Username*</label>
                            <input type="text" class="form-control" name="username">
                        </div>

                        <!-- Password -->
                        <div class="col-md-3">
                            <label for="password" class="form-label">Password*</label>
                            <input type="password" class="form-control" name="password" minlength="8" maxlength="16" required>
                        </div>

                        <!-- Role -->
                        <div class="col-md-3">
                            <label for="role" class="form-label">Role*</label>
                            <select class="form-select" name="role">
                                <option value="Admin">Admin</option>
                                <option value="Staff">Staff</option>
                            </select>
                        </div>

                    </div>

                    <!-- Buttons -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Save User</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Search functionality -->
    <script>
        const searchInput = document.getElementById('searchInput');
        const userRows = document.querySelectorAll('#userTable tbody tr');

        // Store original row HTML
        const rowCache = new Map();
        userRows.forEach((row, i) => {
            rowCache.set(i, row.innerHTML);
        });

        searchInput.addEventListener('input', function () {
            const filter = this.value.toLowerCase().trim();

            userRows.forEach((row, i) => {
                row.innerHTML = rowCache.get(i); // Reset original row HTML

                // Combine text from searchable cells (0 to 4)
                let rowText = '';
                for (let j = 0; j < row.cells.length - 1; j++) {
                    rowText += row.cells[j].textContent.toLowerCase() + ' ';
                }

                const match = rowText.includes(filter);
                row.style.display = match ? '' : 'none';

                // Highlight matching text (except Actions)
                if (match && filter) {
                    for (let j = 0; j < row.cells.length - 1; j++) {
                        const cell = row.cells[j];
                        const originalText = cell.textContent;
                        const regex = new RegExp(`(${filter})`, 'gi');
                        cell.innerHTML = originalText.replace(regex, `<mark>$1</mark>`);
                    }
                }
            });
        });
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var viewModal = document.getElementById('viewUserModal');
            viewModal.addEventListener('show.bs.modal', function (event) {
                var button = event.relatedTarget;

                var fullname = button.getAttribute('data-fullname');
                var username = button.getAttribute('data-username');
                var role = button.getAttribute('data-role');

                document.getElementById('viewFullname').textContent = fullname;
                document.getElementById('viewUsername').textContent = username;
                document.getElementById('viewRole').textContent = role;
            });
        });
    </script>


    <!-- Archive Confirmation Modal -->
    <div class="modal fade" id="archiveModal" tabindex="-1" aria-labelledby="archiveModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form method="POST" action="deleteuser.php">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title" id="archiveModalLabel">Confirm Deactivate</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to deactivate this user?
                        <input type="hidden" name="user_id" id="archiveUserId">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Deactivate</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- View User Modal -->
    <div class="modal fade" id="viewUserModal" tabindex="-1" aria-labelledby="viewUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-custom text-white fw-bold">
                    <h5 class="modal-title" id="viewUserModalLabel">User Details</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Full Name:</label>
                        <p class="fw-bold"><span id="viewFullname"></span></p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Role:</label>
                        <p class="fw-bold"><span id="viewRole"></span></p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Username:</label>
                        <p class="fw-bold"><span id="viewUsername"></span></p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password:</label>
                        <div class="input-group">
                            <input type="password" class="form-control fw-bold" id="viewPassword" readonly>
                            <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                <i class="bi bi-eye-fill"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Edit User Modal -->
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <form action="saveuser.php" method="POST">
                    <div class="modal-header bg-warning text-white">
                        <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body row g-3">
                        <input type="hidden" name="user_id" id="editUserId">

                        <div class="col-md-4">
                            <label class="form-label">First Name*</label>
                            <input type="text" class="form-control" name="firstname" id="editFirstname" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Last Name*</label>
                            <input type="text" class="form-control" name="lastname" id="editLastname" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Middle Name</label>
                            <input type="text" class="form-control" name="middlename" id="editMiddlename">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Username*</label>
                            <input type="text" class="form-control" name="username" id="editUsername" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Password</label>
                            <label class="input-group">
                                <input type="password" class="form-control" name="password" id="editPassword">
                                <button class="btn btn-outline-secondary" type="button" id="togglePass">
                                    <i class="bi bi-eye-fill"></i>
                                </button>
                            </label>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Role*</label>
                            <select class="form-select" name="role" required>
                                <option value="Admin">Admin</option>
                                <option selected value="Staff">Staff</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-warning text-white">Update User</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <!-- Script for diplaying data -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var viewModal = document.getElementById('viewUserModal');
            viewModal.addEventListener('show.bs.modal', function (event) {
                var button = event.relatedTarget;

                var fullname = button.getAttribute('data-fullname');
                var username = button.getAttribute('data-username');
                var role = button.getAttribute('data-role');
                var password = button.getAttribute('data-password');

                document.getElementById('viewFullname').textContent = fullname;
                document.getElementById('viewUsername').textContent = username;
                document.getElementById('viewRole').textContent = role;
                document.getElementById('viewPassword').value = password;
            });

            // Show/hide password toggle
            document.getElementById('togglePassword').addEventListener('click', function () {
                const passwordInput = document.getElementById('viewPassword');
                const icon = this.querySelector('i');
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                icon.classList.toggle('bi-eye');
                icon.classList.toggle('bi-eye-slash');
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var editModal = document.getElementById('editUserModal');
            editModal.addEventListener('show.bs.modal', function (event) {
                var button = event.relatedTarget;

                document.getElementById('editUserId').value = button.getAttribute('data-user_id');
                document.getElementById('editFirstname').value = button.getAttribute('data-firstname');
                document.getElementById('editLastname').value = button.getAttribute('data-lastname');
                document.getElementById('editMiddlename').value = button.getAttribute('data-middlename');
                document.getElementById('editUsername').value = button.getAttribute('data-username');
                document.getElementById('editPassword').value = button.getAttribute('data-password');
                document.getElementById('editRole').value = button.getAttribute('data-role');
            });

            // Show/hide password toggle
            document.getElementById('togglePass').addEventListener('click', function () {
                const passwordInput = document.getElementById('editPassword');
                const icon = this.querySelector('i');
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                icon.classList.toggle('bi-eye');
                icon.classList.toggle('bi-eye-slash');
            });
        });
    </script>

    <!-- addUserModal.adminusers -->
    <?php if (isset($_GET['add']) && $_GET['add'] == 'true'): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var addUserModal = new bootstrap.Modal(document.getElementById('addUserModal'));
                addUserModal.show();
            });
        </script>
    <?php endif; ?>

</body>

</html>