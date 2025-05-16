<?php
function updateMembershipStatus($membershipId, $newStatus, $membershipType)
{

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "beastmodehq";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($newStatus === 'canceled') {

        // For cancellation of membership

        // Calculate the new end date based on today's date + 7 day grace period
        $currentDate = date('Y-m-d');
        $newEndDate = date('Y-m-d', strtotime($currentDate . ' + 7 days'));
        // Update the end date and status
        $stmt = $conn->prepare("UPDATE memberships SET end_date = ?, status = ? WHERE id = ?");
        $stmt->bind_param("ssi", $newEndDate, $newStatus, $membershipId);
    } else {
        // For renewal of membership

        // Calculate the new end date based current date + membership type
        $currentDate = date('Y-m-d');
        $newEndDate = null;

        switch ($membershipType) {
            case 'weekly':
                $newEndDate = date('Y-m-d', strtotime($currentDate . ' + 7 days'));
                break;
            case 'monthly':
                $newEndDate = date('Y-m-d', strtotime($currentDate . ' + 1 month'));
                break;
            case 'yearly':
                $newEndDate = date('Y-m-d', strtotime($currentDate . ' + 1 year'));
                break;
        }
        // Update the end date and status
        $stmt = $conn->prepare("UPDATE memberships SET start_date = ?, end_date = ?, status = ? WHERE id = ?");
        $stmt->bind_param("sssi", $currentDate, $newEndDate, $newStatus, $membershipId);
    }
    $stmt->execute();
    $stmt->close();
    $conn->close();
}
