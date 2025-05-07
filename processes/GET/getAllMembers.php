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

// Set expired status for memberships that are past end date
$sql = "UPDATE memberships SET status = 'expired' WHERE end_date < NOW() AND status != 'expired'";
$conn->query($sql);

// Set active status for memberships that are within 7 days of expiration
$sql = "UPDATE memberships SET status = 'active' WHERE end_date >= NOW() AND status != 'active' AND status != 'canceled' AND status != 'pending'";
$conn->query($sql);

// Fetch memberships with user details
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
if (!empty($search)) {
    $sql = "SELECT 
                memberships.id, 
                users.name,
                users.email, 
                memberships.membership_type, 
                memberships.start_date, 
                memberships.end_date,
                memberships.status 
            FROM memberships
            INNER JOIN users ON memberships.user_id = users.id
            WHERE users.name LIKE ? OR users.email LIKE ?";
    $stmt = $conn->prepare($sql);
    $searchTerm = '%' . $search . '%';
    $stmt->bind_param("ss", $searchTerm, $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $sql = "SELECT 
                memberships.id, 
                users.name,
                users.email, 
                memberships.membership_type, 
                memberships.start_date, 
                memberships.end_date,
                memberships.status 
            FROM memberships
            INNER JOIN users ON memberships.user_id = users.id";
    $result = $conn->query($sql);
}
