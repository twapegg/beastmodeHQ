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

$userId = $_POST['user_id'] ?? null;
$sessionId = $_POST['session_id'] ?? null;

if (!$userId || !$sessionId) {
    // Redirect to class page with error message
    header("Location: ../../classes.php?error=Invalid request.");
    exit();
}

// Check if user membership is active
$membershipStmt = $conn->prepare("SELECT status FROM memberships WHERE user_id = ? AND status = 'active'");
$membershipStmt->bind_param("i", $userId);
$membershipStmt->execute();
$membershipResult = $membershipStmt->get_result();
if ($membershipResult->num_rows === 0) {
    // Redirect to class page with error message
    header("Location: ../../classes.php?error=You must have an active membership to enroll in a class.");
    exit();
}


// Check if the user is already enrolled
$checkStmt = $conn->prepare("SELECT id FROM class_enrollments WHERE user_id = ? AND class_session_id = ? AND status = 'enrolled'");
$checkStmt->bind_param("ii", $userId, $sessionId);
$checkStmt->execute();
$checkStmt->store_result();

if ($checkStmt->num_rows > 0) {
    // Redirect to class page with error message
    header("Location: ../../classes.php?error=You are already enrolled in this session.");
    exit();
}
$checkStmt->close();

// Check current number of enrolled users vs capacity
$capacityStmt = $conn->prepare("
    SELECT cs.capacity, COUNT(ce.id) AS current_enrolled
    FROM class_sessions cs
    LEFT JOIN class_enrollments ce 
        ON cs.id = ce.class_session_id AND ce.status = 'enrolled'
    WHERE cs.id = ?
    GROUP BY cs.id
");
$capacityStmt->bind_param("i", $sessionId);
$capacityStmt->execute();
$capacityResult = $capacityStmt->get_result();
$session = $capacityResult->fetch_assoc();

if (!$session) {
    // Redirect to class page with error message
    header("Location: ../../classes.php?error=Session not found.");
    exit();
}

if ($session['current_enrolled'] >= $session['capacity']) {
    // Redirect to class page with error message
    header("Location: ../../classes.php?error=Session is full.");
    exit();
}
$capacityStmt->close();

// Proceed to enroll the user
$enrollStmt = $conn->prepare("INSERT INTO class_enrollments (user_id, class_session_id, status) VALUES (?, ?, 'enrolled')");
$enrollStmt->bind_param("ii", $userId, $sessionId);

if ($enrollStmt->execute()) {
    // Redirect to class page with success message
    header("Location: ../../member/classes.php?success=Successfully enrolled in the session.");
    exit();
} else {
    // Redirect to class page with error message
    header("Location: ../../classes.php?error=Enrollment failed. Please try again.");
    exit();
}
