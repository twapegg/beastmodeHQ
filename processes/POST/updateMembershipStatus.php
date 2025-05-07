<?php
function updateMembershipStatus($membershipId, $newStatus) {
    
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "beastmodehq";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("UPDATE memberships SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $newStatus, $membershipId);
    $stmt->execute();
    $stmt->close();
    $conn->close();
}
?>