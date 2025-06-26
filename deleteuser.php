<?php
session_start();
require_once "dbconn.php";

if (!isset($_SESSION["username"])) {
    header("Location: loginpage.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['user_id'])) {
    $user_id = intval($_POST['user_id']);

    $query = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
    $query->bind_param("i", $user_id);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows === 0) {
        $_SESSION['message'] = "User not found.";
        header("Location: adminusers.php");
        exit();
    }

    $user = $result->fetch_assoc();

    // Ensure the column count matches the value count in the INSERT statement
    $archive = $conn->prepare("
        INSERT INTO archived_users (
            user_id, firstname, middlename, lastname, role, username, password
        ) VALUES (?, ?, ?, ?, ?, ?, ?)
    ");
    $archive->bind_param(
        "issssss",  // The type definitions should match the columns being bound 
        $user['user_id'],
        $user['firstname'],
        $user['middlename'],
        $user['lastname'],
        $user['role'],
        $user['username'],  
        $user['password']
    );

    $archive->execute();

    $delete = $conn->prepare("DELETE FROM users WHERE user_id = ?");
    $delete->bind_param("i", $user_id);
    $delete->execute();

    $_SESSION['message'] = "User archived successfully.";
    header("Location: adminusers.php");
    exit();
}

header("Location: adminusers.php");
exit();
?>
