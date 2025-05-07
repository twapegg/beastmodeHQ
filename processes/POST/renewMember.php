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

// Set expired status for memberships that are past end date
$sql = "UPDATE memberships SET status = 'expired' WHERE end_date < NOW() AND status != 'expired'";
$conn->query($sql);

// Set active status for memberships that are within 7 days of expiration
$sql = "UPDATE memberships SET status = 'active' WHERE end_date >= NOW() AND end_date <= DATE_ADD(NOW(), INTERVAL 7 DAY) AND status != 'active'";
$conn->query($sql);

// Handle renew request
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['membership_id'])) {
    $membershipId = intval($_POST['membership_id']);

    // Fetch the current membership details
    $query = "SELECT membership_type, end_date FROM memberships WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $membershipId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $membership = $result->fetch_assoc();
        $membershipType = $membership['membership_type'];
        $currentEndDate = $membership['end_date'];

        // Calculate the new end date
        $newEndDate = null;
        switch ($membershipType) {
            case 'daily':
                $newEndDate = date('Y-m-d', strtotime($currentEndDate . ' + 1 day'));
                break;
            case 'weekly':
                $newEndDate = date('Y-m-d', strtotime($currentEndDate . ' + 7 days'));
                break;
            case 'monthly':
                $newEndDate = date('Y-m-d', strtotime($currentEndDate . ' + 1 month'));
                break;
            case 'yearly':
                $newEndDate = date('Y-m-d', strtotime($currentEndDate . ' + 1 year'));
                break;
        }

        // Update the membership's end date
        $updateQuery = "UPDATE memberships SET end_date = ? WHERE id = ?";
        $updateStmt = $conn->prepare($updateQuery);
        $updateStmt->bind_param("si", $newEndDate, $membershipId);

        if ($updateStmt->execute()) {
            header("Location: ../../admin/memberships.php?success=membership_renewed");
        } else {
            header("Location: ../../admin/memberships.php?error=renew_failed");
        }

        $updateStmt->close();
    } else {
        header("Location: ../../admin/memberships.php?error=membership_not_found");
    }

    $stmt->close();
}

$conn->close();
exit();
