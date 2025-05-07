<?php
session_start();

// Check if the user is logged in and their role is admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../../auth/login.php");
    exit();
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "beastmodehq";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle reactivation request
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['membership_id'])) {
    $membershipId = intval($_POST['membership_id']);

    // Update the membership status to 'active'
    $query = "UPDATE memberships SET status = 'active' WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $membershipId);

    if ($stmt->execute()) {
        header("Location: ../../admin/memberships.php?success=membership_activated");
    } else {
        header("Location: ../../admin/memberships.php?error=reactivate_failed");
    }

    $stmt->close();
}

$conn->close();
exit();
