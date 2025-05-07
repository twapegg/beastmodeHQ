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

    // Delete the enrollment record
    $query = "UPDATE class_enrollments SET status='canceled' WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $enrollment_id);

    if ($stmt->execute()) {
        // Redirect back to the sessions page with a success message
        header("Location: ../../admin/sessions.php?success=Member enrollment canceled");
    } else {
        // Redirect back to the sessions page with an error message
        header("Location: ../../admin/sessions.php?error=Failed to cancel member enrollment");
    }

    $stmt->close();
    $conn->close();
}
