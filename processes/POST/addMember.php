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

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email']);
    $membershipType = trim($_POST['membership_type']);
    $startDate = trim($_POST['start_date']);

    // Validate input
    if (empty($email) || empty($membershipType) || empty($startDate)) {
        header("Location: ../../admin/memberships.php?error=empty_fields");
        exit();
    }

    // Calculate end date based on membership type
    $endDate = null;
    switch ($membershipType) {
        case 'daily':
            $endDate = date('Y-m-d', strtotime($startDate . ' + 1 day'));
            break;
        case 'weekly':
            $endDate = date('Y-m-d', strtotime($startDate . ' + 7 days'));
            break;
        case 'monthly':
            $endDate = date('Y-m-d', strtotime($startDate . ' + 1 month'));
            break;
        case 'yearly':
            $endDate = date('Y-m-d', strtotime($startDate . ' + 1 year'));
            break;
    }

    // Check if the user exists
    $userQuery = "SELECT id FROM users WHERE email = ?";
    $stmt = $conn->prepare($userQuery);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $userResult = $stmt->get_result();

    if ($userResult->num_rows === 1) {
        $user = $userResult->fetch_assoc();
        $userId = $user['id'];

        // Insert the membership
        $insertQuery = "INSERT INTO memberships (user_id, membership_type, start_date, end_date, status) VALUES (?, ?, ?, ?, 'pending')";
        $insertStmt = $conn->prepare($insertQuery);
        $insertStmt->bind_param("isss", $userId, $membershipType, $startDate, $endDate);

        if ($insertStmt->execute()) {
            header("Location: ../../admin/memberships.php?success=membership_added");
        } else {
            header("Location: ../../admin/memberships.php?error=insert_failed");
        }

        $insertStmt->close();
    } else {
        header("Location: ../../admin/memberships.php?error=user_not_found");
    }

    $stmt->close();
}

$conn->close();
exit();
