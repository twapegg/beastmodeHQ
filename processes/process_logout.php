<?php
// filepath: c:\xampp\htdocs\beastmodeHQ\processes\process_logout.php

session_start(); // Start the session
session_unset(); // Unset all session variables
session_destroy(); // Destroy the session

// Redirect to the login page
header("Location: ../auth/login.php");
exit();
?>