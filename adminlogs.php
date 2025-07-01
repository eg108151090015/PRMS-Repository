<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "web_system_finals");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT user_logs.*, users.firstname, users.lastname 
        FROM user_logs 
        LEFT JOIN users ON user_logs.user_id = users.user_id 
        ORDER BY user_logs.timestamp DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Logs</title>
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
        .bg-userlogs-header {
            background-color: rgb(58, 148, 208) !important;
            color: white;
        }
        .table thead {
            background-color: rgb(58, 148, 208);
            color: white;
        }
        .content-dropdown:hover .dropdown-menu {
            display: block;
            margin-top: 0;
        }
    </style>
</head>

<body>
    <?php include 'sidebar.php'; ?>

    <div class="content">
        <div class="container-fluid mt-4">
            <div class="card shadow-sm border-0">
                <!-- Card Header -->
                <div class="card-header bg-userlogs-header text-white d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <h4 class="mb-0">User Logs</h4>
                </div>

                <!-- Table -->
                <div class="card-body table-responsive">
                    <table class="table table-hover table-bordered align-middle">
                        <thead>
                            <tr>
                                <th>Log ID</th>
                                <th>User</th>
                                <th>Action</th>
                                <th>Timestamp</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($result->num_rows > 0): ?>
                                <?php while ($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td><?= $row['log_id'] ?></td>
                                        <td><?= htmlspecialchars($row['firstname'] . ' ' . $row['lastname']) ?></td>
                                        <td><?= htmlspecialchars($row['action']) ?></td>
                                        <td><?= $row['timestamp'] ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center">No logs found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
