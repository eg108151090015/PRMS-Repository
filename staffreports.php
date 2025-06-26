<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: loginpage.php");
    exit();
}

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

    @media print {
        body * {
            visibility: hidden;
        }
        .content, .content * {
            visibility: visible;
        }
        .btn-print {
            display: none;
        }
    }

    </style>
</head>

<body>

    <?php include 'sidebar_staff.php'; ?>

    <!-- Main Contents -->
    <div class="content">
        <div class="container">
            <h3 class="mb-4">Reports Dashboard</h3>

            <div class="row g-4">

                <!-- Print Patients List -->
                <div class="col-md-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body text-center">
                            <i class="bi bi-printer-fill fs-1 text-primary mb-3"></i>
                            <h5 class="card-title">Print Patients List</h5>
                            <p class="card-text">Generate and print a full list of all registered patients.</p>
                            <a href="staffprint_allpatients.php" class="btn btn-primary">
                                <i class="bi bi-printer"></i> Print</a>
                        </div>
                    </div>
                </div>

                <!-- Print Single Patient Card -->
                <div class="col-md-4">
                    <div class="card text-center h-100">
                        <div class="card-body">
                            <i class="bi bi-person-lines-fill fs-1 text-success mb-3"></i>
                            <h5 class="card-title">Print Single Patient Record</h5>
                            <p class="card-text">Search and print a specific patient's details.</p>
                            <br>
                            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#searchPatientModal">
                                <i class="bi bi-search"></i> Search
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


    <!-- Modal: Search Patient -->
    <div class="modal fade" id="searchPatientModal" tabindex="-1" aria-labelledby="searchPatientModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-custom text-white fw-bold">
                    <h5 class="modal-title" id="searchPatientModalLabel">Search Patient to Print</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Search Form -->
                    <form method="GET" id="searchForm" class="mb-3">
                        <div class="input-group">
                            <input type="text" name="query" id="searchInput" class="form-control" placeholder="Enter Patient Name..." required>
                            <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i> Search</button>
                        </div>
                    </form>

                    <!-- Results will be injected here -->
                    <div id="searchResults"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.getElementById('searchInput').addEventListener('input', function () {
        const query = this.value.trim();

        if (query.length >= 2) {
            fetch('staffsearch_patientreport.php?query=' + encodeURIComponent(query))
                .then(response => response.text())
                .then(data => {
                    document.getElementById('searchResults').innerHTML = data;
                });
        } else {
            document.getElementById('searchResults').innerHTML = '';
        }
    });
    </script>


</body>

</html>