<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: loginpage.php");
    exit();
}

require_once "dbconn.php";

// Check if POST data is received
/* if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $last_name = $_POST["lastname"];
    $first_name = $_POST["firstname"];
    $middle_name = $_POST["middlename"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $role = $_POST["role"];

    // Prepare and execute SQL
    $stmt = $conn->prepare("INSERT INTO users (lastname, firstname, middlename, username, password, role, created_at) 
                            VALUES (?, ?, ?, ?, ?, ?, NOW())");

    $stmt->bind_param("ssssss", $last_name, $first_name, $middle_name, $username, $password, $role);

    if ($stmt->execute()) {
        $_SESSION['success_message'] = "User added successfully!";
        header("Location: adminusers.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    // If accessed without POST
    header("Location: adduser.php");
    exit();
}
*/

// Collect POST data safely
$user_id    = $_POST['user_id'] ?? null;
$last       = $_POST["lastname"] ?? '';
$first      = $_POST["firstname"] ?? '';
$middle     = $_POST["middlename"] ?? '';
$username   = $_POST["username"] ?? '';
$password   = $_POST["password"] ?? '';
$role       = $_POST["role"] ?? '';


// Check if updating or inserting
if (!empty($user_id)) {
    // Check if patient exists
    $check = $conn->prepare("SELECT user_id FROM users WHERE user_id = ?");
    $check->bind_param("i", $user_id);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        // ✅ Update existing record
        $query = $conn->prepare("
            UPDATE users SET 
                firstname=?, lastname=?, middlename=?, username=?, password=?, role=?
            WHERE user_id=?
        ");

        $query->bind_param("ssssssi", 
            $first, $last, $middle, $username, $password, $role, $user_id
        );

        if ($query->execute()) {
            header("Location: adminusers.php");
            exit();
        } else {
            echo "Error updating record: " . $conn->error;
        }
    }
}

// ✅ Insert new record
$query = $conn->prepare("
    INSERT INTO users (
        firstname, lastname, middlename, username, password, role
    ) VALUES (?, ?, ?, ?, ?, ?)
");

$query->bind_param("ssssss", 
    $first, $last, $middle, $username, $password, $role
);

if ($query->execute()) {
    $new_patient_id = $conn->insert_id;
    header("Location: adminusers.php");
    exit();
} else {
    echo "Error inserting record: " . $query->error;
}
?>

