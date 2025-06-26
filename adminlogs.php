<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: loginpage.php");
    exit();
}

require_once 'dbconn.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Activity Logs - PRMS</title>
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

        .content-dropdown:hover .dropdown-menu {
            display: block;
            margin-top: 0;
        }
    </style>
</head>
<body>

<!-- Top Navbar -->
<nav class="navbar navbar-dark bg-custom fixed-top shadow">
    <div class="container-fluid">
        <span class="navbar-brand mb-0 h1">Patient Record Management System</span>
    </div>
</nav>

<!-- Sidebar -->
<div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-sidebar-custom"
     style="width: 250px; height: 93vh; position: fixed; margin-top: 50px;">
    <div class="text-center mb-2">
        <a href="admindash.php" class="text-decoration-none">
            <img src="pictures/hospital.png" alt="Hospital Logo" width="100" height="120">
        </a>
    </div>

    <hr>

    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="admindash.php" class="nav-link text-white">
                <i class="bi bi-house-door-fill me-2"></i> Home
            </a>
        </li>

        <li class="nav-item dropdown position-relative content-dropdown">
            <a href="adminpatient.php" class="nav-link text-white d-flex justify-content-between align-items-center" id="patientDropdown">
                <span><i class="bi bi-table me-2"></i>Patient Records</span>
                <i class="bi bi-caret-down-fill"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-dark shadow position-absolute" aria-labelledby="patientDropdown">
                <li><a class="dropdown-item" href="adminpatient.php">View Patients Lists</a></li>
                <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#addPatientModal">Add Patients</a></li>
                <li><a class="dropdown-item" href="archivedpatient.php">Archived Patients</a></li>
            </ul>
        </li>

        <li class="nav-item dropdown position-relative content-dropdown">
            <a href="adminusers.php" class="nav-link text-white d-flex justify-content-between align-items-center" id="userDropdown">
                <span><i class="bi bi-people-fill me-2"></i>Users</span>
                <i class="bi bi-caret-down-fill"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-dark shadow position-absolute" aria-labelledby="userDropdown">
                <li><a class="dropdown-item" href="adminusers.php">View Users</a></li>
                <li><a class="dropdown-item" href="adduser.php">Add Users</a></li>
                <li><a class="dropdown-item" href="archiveduser.php">Archived Users</a></li>
            </ul>
        </li>

        <li>
            <a href="adminlogs.php" class="nav-link active text-white">
                <i class="bi bi-folder-fill me-2"></i> Logs
            </a>
        </li>

        <li>
            <a href="adminreports.php" class="nav-link text-white">
                <i class="bi bi-clipboard-fill me-2"></i> Reports
            </a>
        </li>
    </ul>

    <hr>

    <div class="dropdown">
        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
           id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="pictures/profile.png" alt="" width="34" height="45" class="rounded-circle me-2">
            <strong><?php echo $_SESSION["name"]; ?></strong>
        </a>
        <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
            <li><a class="dropdown-item" href="logout.php"
                   onclick="return confirm('Are you sure you want to logout?');">Sign out</a></li>
        </ul>
    </div>
</div>

<!-- Main Content -->
<div class="content">
    <div class="container">
        <h3 class="mb-4">Activity Logs</h3>

        <div class="table-responsive shadow rounded">
            <table class="table table-bordered table-striped bg-white">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Username</th>
                        <th>Activity</th>
                        <th>Date & Time</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $logQuery = "SELECT * FROM logs ORDER BY timestamp DESC";
                    $logResult = mysqli_query($conn, $logQuery);

                    if (mysqli_num_rows($logResult) > 0) {
                        $count = 1;
                        while ($row = mysqli_fetch_assoc($logResult)) {
                            echo "<tr>
                                <td>{$count}</td>
                                <td>{$row['username']}</td>
                                <td>{$row['activity']}</td>
                                <td>{$row['timestamp']}</td>
                              </tr>";
                            $count++;
                        }
                    } else {
                        echo "<tr><td colspan='4' class='text-center'>No logs found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
