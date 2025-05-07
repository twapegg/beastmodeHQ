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
    $class_id = $_POST['class_id'];
    $session_date = $_POST['session_date'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $capacity = $_POST['capacity'];

    // Update the session in the database
    $query = "UPDATE class_sessions SET class_id = ?, session_date = ?, start_time = ?, end_time = ?, capacity = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("isssii", $class_id, $session_date, $start_time, $end_time, $capacity, $session_id);

    if ($stmt->execute()) {
        header("Location: ../../admin/sessions.php?success=Session updated successfully");
    } else {
        header("Location: ../../admin/sessions.php?error=Failed to update session");
    }

    $stmt->close();
    $conn->close();
}
?>