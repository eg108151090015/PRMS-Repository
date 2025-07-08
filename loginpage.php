<?php
session_start();
require_once "dbconn.php";

$alertMessage = "";
$alertIcon = "";
$redirectURL = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT user_id, firstname, lastname, username, password, role, status FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();

    if ($row['status'] !== 'active') {
        $alertMessage = "Account is inactive. Please contact administrator.";
        $alertIcon = "error";
    } elseif (password_verify($password, $row['password'])) {
        $_SESSION["user_id"] = $row['user_id'];
        $_SESSION["username"] = $row['username'];
        $_SESSION["name"] = $row['firstname'] . ' ' . $row['lastname'];
        $_SESSION["role"] = $row['role'];

        $alertMessage = "Welcome, " . $_SESSION["name"] . "!";
        $alertIcon = "success";

        if ($row['role'] === 'admin') {
            $redirectURL = "admindash.php";
        } elseif ($row['role'] === 'staff') {
            $redirectURL = "staffdash.php";
        } else {
            $alertMessage = "Unknown role. Access denied.";
            $alertIcon = "error";
        }
    } else {
        $alertMessage = "Invalid username or password.";
        $alertIcon = "error";
    }
}else {
        $alertMessage = "Invalid username or password.";
        $alertIcon = "error";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="loginstyle.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<?php if (!empty($alertMessage)): ?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        Swal.fire({
            icon: '<?= $alertIcon ?>',
            title: '<?= $alertIcon === "success" ? "Login Successful" : "Login Failed" ?>',
            text: '<?= $alertMessage ?>',
            showConfirmButton: false,
            timer: 2000
        }).then(() => {
            <?php if ($alertIcon === "success" && $redirectURL): ?>
                window.location.href = "<?= $redirectURL ?>";
            <?php endif; ?>
        });
    });
</script>
<?php endif; ?>

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

        <?php if (!empty($error)): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                showAlert("<?= $error ?>", "error", "Login Failed", 2000);
            });
        </script>
        <?php endif; ?>

      </div>
    </div>
  </div>
</body>
</html>