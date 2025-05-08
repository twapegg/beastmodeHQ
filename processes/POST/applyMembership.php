<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "beastmodehq";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle membership application
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['user_id'];
    $membershipType = $_POST['membership_type'];
    $startDate = date('Y-m-d');
    $endDate = date('Y-m-d', strtotime("+1 " . $membershipType));

    // Insert membership into the database
    $stmt = $conn->prepare("INSERT INTO memberships (user_id, start_date, end_date, membership_type, status) VALUES (?, ?, ?, ?, 'pending')");
    $stmt->bind_param("isss", $userId, $startDate, $endDate, $membershipType);

    if ($stmt->execute()) {
        // Update user's membership_id
        $membershipId = $conn->insert_id;
        $updateStmt = $conn->prepare("UPDATE users SET membership_id = ? WHERE id = ?");
        $updateStmt->bind_param("ii", $membershipId, $userId);
        $updateStmt->execute();

        // Redirect to the membership page with success message
        header("Location: ../member/membership.php?success=Membership application submitted successfully. Please wait for approval.");

        exit();
    } else {
        $error = "Failed to apply for membership. Please try again.";
    }
}
?>