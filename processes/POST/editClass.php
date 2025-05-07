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

// Handle edit request
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['class_id'])) {
    $classId = intval($_POST['class_id']);
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);

    // Validate input
    if (empty($name)) {
        header("Location: ../../admin/classes.php?error=empty_fields");
        exit();
    }

    // Update the class
    $query = "UPDATE classes SET name = ?, description = ?, updated_at = NOW() WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssi", $name, $description, $classId);

    if ($stmt->execute()) {
        header("Location: ../../admin/classes.php?success=class_updated");
    } else {
        header("Location: ../../admin/classes.php?error=update_failed");
    }

    $stmt->close();
}

$conn->close();
exit();
?>