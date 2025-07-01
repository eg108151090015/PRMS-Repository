<?php
session_start();
require_once "dbconn.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Prepare a secure query
    $stmt = $conn->prepare("SELECT user_id, firstname, lastname, username, password, role FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();

        // Verify password using hash
        if (password_verify($password, $row['password'])) {
            $_SESSION["user_id"] = $row['user_id']; //  required for logs
            $_SESSION["username"] = $row['username'];
            $_SESSION["name"] = $row['firstname'] . ' ' . $row['lastname'];
            $_SESSION["role"] = $row['role'];

            // Redirect based on role
            if ($row['role'] === 'admin') {
                header("Location: admindash.php");
                exit();
            } elseif ($row['role'] === 'staff') {
                header("Location: staffdash.php");
                exit();
            } else {
                $error = "Unknown role. Access denied.";
            }
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="loginstyle.css">
</head>
<body>
  <div class="login-container">
    <div class="login-box">
      <div class="login-image">
        <img src="pictures/login.png" alt="Login Illustration">
      </div>
      <div class="login-form">
        <h2>SIGN IN</h2>
        <form method="POST" action="">
          <label for="username">Username</label>
          <input type="text" id="username" name="username" required>

          <label for="password">Password</label>
          <input type="password" id="password" name="password" required>

          <button type="submit">Sign In</button>
        </form>
        <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
      </div>
    </div>
  </div>
</body>
</html>