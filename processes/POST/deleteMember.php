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

// Handle delete request
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['membership_id'])) {
    $membershipId = intval($_POST['membership_id']);

    // Delete the membership
    $query = "DELETE FROM memberships WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $membershipId);

    if ($stmt->execute()) {
        header("Location: ../../admin/memberships.php?success=ID $membershipId Membership Deleted");
    } else {
        header("Location: ../../admin/memberships.php?error=ID $membershipId Membership Deletion Failed");
    }

    $stmt->close();
}

$conn->close();
exit();
?>