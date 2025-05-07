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
    $class_id = $_POST['class_id'];
    $session_date = $_POST['session_date'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $capacity = $_POST['capacity'];

    // Insert the new session into the database
    $query = "INSERT INTO class_sessions (class_id, session_date, start_time, end_time, capacity) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("isssi", $class_id, $session_date, $start_time, $end_time, $capacity);

    if ($stmt->execute()) {
        header("Location: ../../admin/sessions.php?success=Session added successfully");
    } else {
        header("Location: ../../admin/sessions.php?error=Failed to add session");
    }

    $stmt->close();
    $conn->close();
}
?>