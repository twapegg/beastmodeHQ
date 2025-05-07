<?php
session_start();

// Check if the user is logged in and their role is 'member'
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'member') {
    header("Location: ../auth/login.php");
    exit();
}

// Include database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "beastmodehq";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['session_id'])) {
    $userId = $_SESSION['user_id'];
    $classSessionId = intval($_POST['session_id']);

    // Update the enrollment status to 'cancelled'
    $stmt = $conn->prepare("UPDATE class_enrollments SET status = 'canceled' WHERE user_id = ? AND class_session_id = ?");
    $stmt->bind_param("ii", $userId, $classSessionId);

    if ($stmt->execute()) {
        header("Location: ../../member/classes.php?success=Enrollment cancelled successfully!");
        exit();
    } else {
        header("Location: ../../member/classes.php?error=Failed to cancel enrollment. Please try again.");
        exit();
    }
}
?>