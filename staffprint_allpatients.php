<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: loginpage.php");
    exit();
}

// include('dbconn.php');

require_once 'dbconn.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Print All Patients</title>
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

        .table th, .table td {
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
            <h4>All Registered Patients</h4>
            <p>Date Printed: <?php echo date('F d, Y - h:i A'); ?></p>
        </div>

        <div class="no-print text-end print-btn">
            <a href="staffreports.php" class="btn btn-secondary">Back</a>
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
                $query = "SELECT * FROM patients ORDER BY last_name ASC";
                $result = mysqli_query($conn, $query);

                if (mysqli_num_rows($result) > 0) {
                    $count = 1;
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<tr>
                                <td>' . $count++ . '</td>
                                <td>' . $row['patient_id'] . '</td>
                                <td>' . $row['last_name'] . ', ' . $row['first_name'] . '</td>
                                <td>' . $row['date_of_birth'] . '</td>
                                <td>' . $row['gender'] . '</td>
                                <td>' . $row['contact_number'] . '</td>
                                <td>' . $row['address'] . '</td>
                            </tr>';
                    }
                } else {
                    echo '<tr><td colspan="7" class="text-center text-danger">No patients found.</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>

</body>

</html>
