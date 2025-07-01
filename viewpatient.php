<?php

// viewpatient.php

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

    <?php include 'sidebar.php'; ?>
        
    <?php include 'main_content_view_record.php'; ?>

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