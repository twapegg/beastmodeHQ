<?php

include "db.php"; // Include the database connection

// Fetch class sessions with total enrolled members
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
if (!empty($search)) {
    $query = "SELECT 
                cs.id, 
                cs.session_date, 
                cs.start_time, 
                cs.end_time, 
                cs.capacity, 
                c.name AS class_name, 
                COUNT(ce.id) AS total_enrolled
              FROM class_sessions cs
              INNER JOIN classes c ON cs.class_id = c.id
              LEFT JOIN class_enrollments ce ON cs.id = ce.class_session_id AND ce.status = 'enrolled'
              WHERE c.name LIKE ? OR cs.session_date LIKE ?
              GROUP BY cs.id
              ORDER BY cs.session_date ASC";
    $stmt = $conn->prepare($query);
    $searchTerm = '%' . $search . '%';
    $stmt->bind_param("ss", $searchTerm, $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $query = "SELECT 
                cs.id, 
                cs.session_date, 
                cs.start_time, 
                cs.end_time, 
                cs.capacity, 
                c.name AS class_name, 
                COUNT(ce.id) AS total_enrolled
              FROM class_sessions cs
              INNER JOIN classes c ON cs.class_id = c.id
              LEFT JOIN class_enrollments ce ON cs.id = ce.class_session_id AND ce.status = 'enrolled'
              GROUP BY cs.id
              ORDER BY cs.session_date ASC";
    $result = $conn->query($query);
}

// Check if the query returned results
if (!$result) {
    die("Query failed: " . $conn->error);
}
