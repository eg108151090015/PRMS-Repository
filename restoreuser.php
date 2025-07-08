<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: loginpage.php");
    exit();
}

require_once "dbconn.php";

// Check if user_id is provided via GET
if (!isset($_GET['user_id'])) {
    echo "No user ID provided.";
    exit();
}

$user_id = intval($_GET['user_id']);

// Fetch archived user record
$query = $conn->prepare("SELECT * FROM archived_users WHERE user_id = ?");
$query->bind_param("i", $user_id);
$query->execute();
$result = $query->get_result();

if ($result->num_rows === 0) {
    echo "Archived user not found.";
    exit();
}

$archived = $result->fetch_assoc();

// Insert back into users table
/*$insert = $conn->prepare("
    INSERT INTO users (
        firstname, middlename, lastname, role, username, password
    ) VALUES (?, ?, ?, ?, ?, ?)
");
$insert->bind_param(
    "ssssss",
    $archived['firstname'],
    $archived['middlename'],
    $archived['lastname'],
    $archived['role'],
    $archived['username'],
    $archived['password']
);
$insert->execute();*/

$status = $conn->prepare("UPDATE users SET status = 'active' WHERE user_id = ?");
$status->bind_param("i", $user_id);
$status->execute();

// Delete from archived_users table
$delete = $conn->prepare("DELETE FROM archived_users WHERE user_id = ?");
$delete->bind_param("i", $user_id);
$delete->execute();

$log_user_id = $_SESSION['user_id'];
$target_user_name = $archived['lastname'] . ' ' . $archived['firstname'] . ' ' . $archived['middlename'];
$target_user_id = $archived['user_id'];

$action = "Activated user account (ID: $target_user_id, Name: $target_user_name)";
$stmt = $conn->prepare("INSERT INTO user_logs (user_id, action) VALUES (?, ?)");
$stmt->bind_param("is", $log_user_id, $action);
$stmt->execute();

// Redirect back to archived users page
header("Location: archiveduser.php?status=activated");
exit();
?>