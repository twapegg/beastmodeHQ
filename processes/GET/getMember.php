<?php
// filepath: c:\xampp\htdocs\beastmodeHQ\processes\GET\members.php

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

// Fetch memberships with user details
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
if (!empty($search)) {
    $sql = "SELECT 
                memberships.id, 
                users.name, 
                users.email, 
                memberships.membership_type, 
                memberships.start_date, 
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
                memberships.status 
            FROM memberships
            INNER JOIN users ON memberships.user_id = users.id";
    $result = $conn->query($sql);
}
