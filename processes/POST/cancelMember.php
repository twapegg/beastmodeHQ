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

// Handle cancel request
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['membership_id'])) {
    $membershipId = intval($_POST['membership_id']);

    // Update the membership status to 'canceled'
    $updateQuery = "UPDATE memberships SET status = 'canceled' WHERE id = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("i", $membershipId);

    if ($stmt->execute()) {
        header("Location: ../../admin/memberships.php?success=membership_canceled");
    } else {
        header("Location: ../../admin/memberships.php?error=cancel_failed");
    }

    $stmt->close();
}

$conn->close();
exit();
