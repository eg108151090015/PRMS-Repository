<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: loginpage.php");
    exit();
}

require_once 'dbconn.php';

$reportType = $_GET['report_type'] ?? '';
$dateInput = $_GET['date'] ?? '';

if (!$reportType || !$dateInput) {
    echo "Invalid input.";
    exit;
}

$date = new DateTime($dateInput);
$startDate = '';
$endDate = '';
$label = '';

switch ($reportType) {
    case 'daily':
        $startDate = $date->format('Y-m-d 00:00:00');
        $endDate = $date->format('Y-m-d 23:59:59');
        $label = "Daily Report for " . $date->format('F j, Y');
        break;

    case 'weekly':
        $weekStart = clone $date;
        $weekStart->modify('monday this week');
        $weekEnd = clone $weekStart;
        $weekEnd->modify('+6 days');
        $startDate = $weekStart->format('Y-m-d 00:00:00');
        $endDate = $weekEnd->format('Y-m-d 23:59:59');
        $label = "Weekly Report (" . $weekStart->format('M j') . " - " . $weekEnd->format('M j, Y') . ")";
        break;

    case 'monthly':
        $startDate = $date->format('Y-m-01 00:00:00');
        $endDate = $date->format('Y-m-t 23:59:59');
        $label = "Monthly Report for " . $date->format('F Y');
        break;

    default:
        echo "Invalid report type.";
        exit;
}

// Fetch patient records in the date range
$query = $conn->prepare("SELECT * FROM patients WHERE created_at BETWEEN ? AND ? ORDER BY last_name ASC");
$query->bind_param("ss", $startDate, $endDate);
$query->execute();
$result = $query->get_result();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Patient Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @media print {
            .no-print {
                display: none;
            }
        }

        body {
            font-family: Arial, sans-serif;
            background-color: white;
        }

        .container {
            margin-top: 30px;
        }

        .table th,
        .table td {
            vertical-align: middle;
        }

        .header-text {
            text-align: center;
            margin-bottom: 30px;
        }

        .header-text h2 {
            margin-bottom: 5px;
        }

        .print-btn {
            margin-bottom: 15px;
        }
    </style>
</head>

<body onload="window.print()">

    <div class="container">
        <div class="header-text">
            <h2>Patient Record Management System</h2>
            <h4><?php echo $label; ?></h4>
            <p>Date Printed: <?php echo date('F d, Y - h:i A'); ?></p>
        </div>

        <div class="no-print text-end print-btn">
            <a href="adminreports.php" class="btn btn-secondary">Back</a>
            <button onclick="window.print()" class="btn btn-primary">Print Again</button>
        </div>

        <table class="table table-bordered table-striped">
            <thead class="table-primary">
                <tr>
                    <th>#</th>
                    <th>Patient ID</th>
                    <th>Full Name</th>
                    <th>Birthdate</th>
                    <th>Gender</th>
                    <th>Contact No.</th>
                    <th>Address</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    $count = 1;
                    while ($row = $result->fetch_assoc()) {
                        echo '<tr>
                            <td>' . $count++ . '</td>
                            <td>' . $row['patient_id'] . '</td>
                            <td>' . htmlspecialchars($row['last_name']) . ', ' . htmlspecialchars($row['first_name']) . '</td>
                            <td>' . htmlspecialchars($row['date_of_birth']) . '</td>
                            <td>' . htmlspecialchars($row['gender']) . '</td>
                            <td>' . htmlspecialchars($row['contact_number']) . '</td>
                            <td>' . htmlspecialchars($row['address']) . '</td>
                        </tr>';
                    }
                } else {
                    echo '<tr><td colspan="7" class="text-center text-danger">No patients found for this period.</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>

</body>

</html>
