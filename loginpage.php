<?php
session_start();
include "dbconn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string($_POST['password']);

    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $_SESSION["username"] = $row['username'];
        $_SESSION["name"] = $row['firstname'] . ' ' . $row['lastname']; // ← Add this line
        $_SESSION["role"] = $row['role'];


        if ($row['role'] === 'admin') {
            header("Location: admindash.php");
            exit();
        } elseif ($row['role'] === 'staff') {
            header("Location: staffdash.php"); // Create this file if it doesn't exist
            exit();
        } else {
            $error = "Unknown role. Access denied.";
        }
    } else {
        $error = "Invalid username or password!";
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
        <form action="" method="POST">
          <label for="username">Username</label>
          <input type="text" id="username" name="username">

          <label for="password">Password</label>
          <input type="password" id="password" name="password">

          <button type="submit">Sign In</button>
        </form>
        <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
      </div>
    </div>
  </div>
</body>

</html>
