<?php
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
    $userId = $_POST['user_id'] ?? null;
    $sessionId = $_POST['class_session_id'] ?? null;
    $status = $_POST['status'] ?? 'present';

    if (!$userId || !$sessionId || !in_array($status, ['present', 'absent', 'late'])) {
        die("Invalid input.");
    }

    // Check if attendance already exists for this user + session
    $checkStmt = $conn->prepare("SELECT id FROM attendance WHERE user_id = ? AND class_session_id = ?");
    $checkStmt->bind_param("ii", $userId, $sessionId);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult->num_rows > 0) {
        // Update existing attendance
        $row = $checkResult->fetch_assoc();
        $attendanceId = $row['id'];
        $updateStmt = $conn->prepare("UPDATE attendance SET status = ?, attendance_time = NOW() WHERE id = ?");
        $updateStmt->bind_param("si", $status, $attendanceId);
        $updateStmt->execute();
    } else {
        // Insert new attendance record
        $insertStmt = $conn->prepare("INSERT INTO attendance (user_id, class_session_id, status) VALUES (?, ?, ?)");
        $insertStmt->bind_param("iis", $userId, $sessionId, $status);
        $insertStmt->execute();
    }

    header("Location: " . $_SERVER['HTTP_REFERER']); // Redirect back
    exit;
} else {
    die("Invalid request.");
}
