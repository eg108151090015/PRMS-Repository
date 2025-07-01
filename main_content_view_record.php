<?php
$conn = new mysqli("localhost", "root", "", "web_system_Finals");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$patient_id = $_GET['patient_id'] ?? null;
if (!$patient_id) {
    die("No patient_id provided in URL.");
}

$stmt = $conn->prepare("SELECT * FROM patients WHERE patient_id = ?");
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("i", $patient_id);
$stmt->execute();
$result = $stmt->get_result();
$patient = $result->fetch_assoc();

if (!$patient) {
    die("No patient found.");
}

// Now use $patient to display info
echo "Patient: " . htmlspecialchars($patient['first_name']) . " " . htmlspecialchars($patient['last_name']);

$backUrl = ($_SESSION['role'] === 'admin') ? 'adminpatient.php' : 'staffpatient.php';

?>


<!DOCTYPE html>
<html>
<head>
    <title>View Patient</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="content">
    <div class="container-fluid py-4">

        <!-- Navigation -->
        <div class="mb-3 d-flex justify-content-between">
    <a href="<?= $backUrl ?>" class="btn bg-custom text-white">
                <i class="bi bi-arrow-left"></i> Back to Patient List
            </a>
        </div>

        <!-- Patient Name -->
        <div class="row">
            <div class="col-md-8 mb-3">
                <div class="card shadow-sm border-0 border-start-custom">
                    <div class="card-body">
                        <h6 class="text-primary">Patient Name</h6>
                        <h4 class="mb-0"><?= htmlspecialchars($patient['last_name'] . ', ' . $patient['first_name'] . ' ' . $patient['middle_name']) ?></h4>
                    </div>
                </div>
            </div>

            <!-- Patient No -->
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm border-0 border-start-custom">
                    <div class="card-body">
                        <h6 class="text-primary">Patient No.</h6>
                        <h4 class="mb-0"><?= htmlspecialchars($patient['patient_id']) ?></h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- Info -->
        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header text-primary d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Patient Information</h6>
                        <a href="#" class="text-decoration-none text-primary" data-bs-toggle="modal" data-bs-target="#editPatientModal">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                    </div>
                    <div class="card-body">
                        <p>ADDRESS:<br><strong><?= htmlspecialchars($patient['address']) ?></strong></p>
                        <p>AGE:<br><strong><?= htmlspecialchars($patient['age']) ?></strong></p>
                        <p>BIRTHDATE:<br><strong><?= htmlspecialchars($patient['date_of_birth']) ?></strong></p>
                        <p>BIRTHPLACE:<br><strong><?= htmlspecialchars($patient['birth_place']) ?></strong></p>
                        <p>NATIONALITY:<br><strong><?= htmlspecialchars($patient['nationality']) ?></strong></p>
                        <p>RELIGION:<br><strong><?= htmlspecialchars($patient['religion']) ?></strong></p>
                        <p>CIVIL STATUS:<br><strong><?= htmlspecialchars($patient['civil_status']) ?></strong></p>
                        <p>OCCUPATION:<br><strong><?= htmlspecialchars($patient['occupation']) ?></strong></p>
                        <p>GENDER:<br><strong><?= htmlspecialchars($patient['gender']) ?></strong></p>
                        <p>CONTACT NO.:<br><strong><?= htmlspecialchars($patient['contact_number']) ?></strong></p>
                        <p>EMAIL ADDRESS:<br><strong><?= htmlspecialchars($patient['email_address']) ?></strong></p>
                    </div>
                </div>
            </div>

            <!-- Print Buttons -->
            <div class="col">
                <div id="recordSelection" class="text-center mb-4">
                    <a href="opd.php?patient_id=<?= urlencode($patient['patient_id']) ?>" class="btn btn-primary">
                        <i class="bi bi-printer"></i> Print OPD
                    </a>
                    <a href="opdfeeform.php?patient_id=<?= urlencode($patient['patient_id']) ?>" class="btn btn-primary">
                        <i class="bi bi-printer"></i> Print Doctor's Fee Form
                    </a>

                    
                </div>
            </div>
        </div>

    </div>
</div>

<script>
function showAdmission() {
    window.open("admission_record.php?patient_id=<?= $patient['id'] ?>", "_blank");
}
</script>

</body>
</html>
<?php $conn->close(); ?>
