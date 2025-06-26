<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: loginpage.php");
    exit();
}

require_once 'dbconn.php';

// Example query to get total number of patients
$query = "SELECT COUNT(*) FROM patients";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$totalPatients = $row['COUNT(*)'];

// Example query to get total number of users
$queryU = "SELECT COUNT(*) FROM users";
$resultU = mysqli_query($conn, $queryU);
$rowU = mysqli_fetch_assoc($resultU);
$totalUsers = $rowU['COUNT(*)'];
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>PRMS</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
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

    /* Active link styling */
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

    a .card:hover {
        background-color: #f0f8ff;
        transition: 0.3s ease;
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

    <!-- Main Contents -->
    <div class="content">
        <div class="container mt-4">
            <div class="row g-4 align-items-stretch">

                <!-- Patient Card -->
                <div class="col-md-3 d-flex">
                    <a href="adminpatient.php" class="text-decoration-none text-dark w-100">
                        <div class="card text-center shadow-sm bg-body rounded border-0 d-flex flex-column h-100">
                            <img src="pictures/patient_list.png" class="card-img-top mx-auto mt-3" alt="Patients"
                                style="width: 100px; height: 115px;">
                            <div class="card-body d-flex flex-column justify-content-between">
                                <div>
                                    <h5 class="card-title fw-bold">PATIENTS</h5>
                                    <p class="card-text mb-1">No. of patients:</p>
                                    <h6 class="fw-bold"><?= $totalPatients?></h6>
                                </div>
                                <span class="text-primary">Manage</span>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Users Card -->
                <div class="col-md-3 d-flex">
                    <a href="adminusers.php" class="text-decoration-none text-dark w-100">
                        <div class="card text-center shadow-sm bg-body rounded border-0 d-flex flex-column h-100">
                            <img src="pictures/users.png" class="card-img-top mx-auto mt-3" alt="Users"
                                style="width: 100px; height: 115px;">
                            <div class="card-body d-flex flex-column justify-content-between">
                                <div>
                                    <h5 class="card-title fw-bold">USERS</h5>
                                    <p class="card-text mb-1">No. of users:</p>
                                    <h6 class="fw-bold"><?= $totalUsers?></h6>
                                </div>
                                <span class="text-primary">Manage</span>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Logs Card
                <div class="col-md-3 d-flex">
                    <a href="adminlogs.php" class="text-decoration-none text-dark w-100">
                        <div class="card text-center shadow-sm bg-body rounded border-0 d-flex flex-column h-100">
                            <img src="pictures/logs.png" class="card-img-top mx-auto mt-3" alt="Logs"
                                style="width: 100px; height: 115px;">
                            <div class="card-body d-flex flex-column justify-content-between">
                                <div>
                                    <h5 class="card-title fw-bold">LOGS</h5>
                                    <p class="card-text mb-1">System access logs</p>
                                    <h6 class="fw-bold"><?= $totalUsers." entries"?></h6>
                                </div>
                                <span class="text-primary">Manage</span>
                            </div>
                        </div>
                    </a>
                </div>  
                -->

                <!-- Reports Card -->
                <div class="col-md-3 d-flex">
                    <a href="adminreports.php" class="text-decoration-none text-dark w-100">
                        <div class="card text-center shadow-sm bg-body rounded border-0 d-flex flex-column h-100">
                            <img src="pictures/reports.png" class="card-img-top mx-auto mt-3" alt="Reports"
                                style="width: 100px; height: 115px;">
                            <div class="card-body d-flex flex-column justify-content-between">
                                <div>
                                    <h5 class="card-title fw-bold">REPORTS</h5>
                                    <p class="card-text mb-1">Manage patient <br>records reports</p>
                                </div>
                                <span class="text-primary">Manage</span>
                            </div>
                        </div>
                    </a>
                </div>


            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    
</body>

</html>