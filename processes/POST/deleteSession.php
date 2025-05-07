<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "beastmodehq";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $session_id = $_POST['session_id'];

    // Delete the session from the database
    $query = "DELETE FROM class_sessions WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $session_id);

    if ($stmt->execute()) {
        header("Location: ../../admin/sessions.php?success=Session deleted successfully");
    } else {
        header("Location: ../../admin/sessions.php?error=Failed to delete session");
    }

    $stmt->close();
    $conn->close();
}
