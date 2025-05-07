<?php

include "db.php"; // Ensure the correct path to db.php

// Fetch classes
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$classes = []; // Initialize an empty array to store classes

if (!empty($search)) {
    $query = "SELECT * FROM classes WHERE name LIKE ? ORDER BY created_at DESC";
    $stmt = $conn->prepare($query);
    $searchTerm = '%' . $search . '%';
    $stmt->bind_param("s", $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $query = "SELECT * FROM classes ORDER BY created_at DESC";
    $result = $conn->query($query);
}

// Store the results in the $classes array
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $classes[] = $row;
    }
}

// Check if the query failed
if (!$result) {
    die("Query failed: " . $conn->error);
}
?>