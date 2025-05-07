<?php
session_start();

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


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $enrollment_id = $_POST['enrollment_id'];

    // Update the enrollment status to 'enrolled'
    $query = "UPDATE class_enrollments SET status = 'enrolled' WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $enrollment_id);

    if ($stmt->execute()) {
        header("Location: ../../admin/sessions.php?success=User re-enrolled successfully");
    } else {
        header("Location: ../../admin/sessions.php?error=Failed to re-enroll user");
    }

    $stmt->close();
    $conn->close();
}
?>