<?php
// logout.php

// Start session
session_start();

// Destroy the session
session_unset(); // Remove all session variables
session_destroy(); // Destroy the session
echo "<script>window.location.href = 'loginpage.php';</script>";
// Redirect to the login page
exit();
?>
