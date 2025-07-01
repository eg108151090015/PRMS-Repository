<?php
session_start();
require_once "dbconn.php";

// Check if logged in
if (!isset($_SESSION["username"], $_SESSION["user_id"])) {
    header("Location: loginpage.php");
    exit();
}

$log_user_id = $_SESSION['user_id']; // The logged-in user doing the action

// Collect POST data safely
$user_id   = $_POST['user_id'] ?? null;
$last      = trim($_POST["lastname"] ?? '');
$first     = trim($_POST["firstname"] ?? '');
$middle    = trim($_POST["middlename"] ?? '');
$username  = trim($_POST["username"] ?? '');
$password  = $_POST["password"] ?? '';
$role      = $_POST["role"] ?? '';

$fullName = $last . ' ' . $first . ' ' . $middle;

// Check for duplicate username (whether inserting or updating)
if (empty($user_id)) {
    $checkUser = $conn->prepare("SELECT user_id FROM users WHERE username = ?");
    $checkUser->bind_param("s", $username);
} else {
    $checkUser = $conn->prepare("SELECT user_id FROM users WHERE username = ? AND user_id != ?");
    $checkUser->bind_param("si", $username, $user_id);
}
$checkUser->execute();
$checkUser->store_result();

if ($checkUser->num_rows > 0) {
    $_SESSION['message'] = "Username already exists!";
    header("Location: adduser.php");
    exit();
}

// ---------------------
// Update Existing User
// ---------------------
if (!empty($user_id)) {
    // Check if user exists
    $check = $conn->prepare("SELECT user_id FROM users WHERE user_id = ?");
    $check->bind_param("i", $user_id);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        // Update
        if (!empty($password)) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $query = $conn->prepare("
                UPDATE users SET 
                    firstname = ?, lastname = ?, middlename = ?, username = ?, password = ?, role = ?
                WHERE user_id = ?
            ");
            $query->bind_param("ssssssi", $first, $last, $middle, $username, $hashedPassword, $role, $user_id);
        } else {
            $query = $conn->prepare("
                UPDATE users SET 
                    firstname = ?, lastname = ?, middlename = ?, username = ?, role = ?
                WHERE user_id = ?
            ");
            $query->bind_param("sssssi", $first, $last, $middle, $username, $role, $user_id);
        }

        if ($query->execute()) {
            // Log update
            $action = "Updated user account (ID: $user_id, Name: $fullName, Role: $role)";
            $logStmt = $conn->prepare("INSERT INTO user_logs (user_id, action) VALUES (?, ?)");
            $logStmt->bind_param("is", $log_user_id, $action);
            $logStmt->execute();

            $_SESSION['message'] = "User updated successfully.";
            header("Location: adminusers.php");
            exit();
        } else {
            echo "Error updating record: " . $conn->error;
            exit();
        }
    } else {
        $_SESSION['message'] = "User not found.";
        header("Location: adminusers.php");
        exit();
    }
}

// ---------------------
// Insert New User
// ---------------------
if (empty($password)) {
    $_SESSION['message'] = "Password is required.";
    header("Location: adduser.php");
    exit();
}

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$query = $conn->prepare("
    INSERT INTO users (
        firstname, lastname, middlename, username, password, role
    ) VALUES (?, ?, ?, ?, ?, ?)
");
$query->bind_param("ssssss", $first, $last, $middle, $username, $hashedPassword, $role);

if ($query->execute()) {
    $new_user_id = $conn->insert_id;

    // Log insert
    $action = "Added new user account (ID: $new_user_id, Name: $fullName, Role: $role)";
    $logStmt = $conn->prepare("INSERT INTO user_logs (user_id, action) VALUES (?, ?)");
    $logStmt->bind_param("is", $log_user_id, $action);
    $logStmt->execute();

    $_SESSION['message'] = "User added successfully.";
    header("Location: adminusers.php");
    exit();
} else {
    echo "Error inserting record: " . $query->error;
    exit();
}
?>
