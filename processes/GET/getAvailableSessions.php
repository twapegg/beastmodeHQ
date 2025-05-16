<?php
include "db.php";

$userId = $_SESSION['user_id'] ?? null;
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$searchTerm = '%' . $search . '%';

$baseQuery = "SELECT 
                cs.id, 
                cs.session_date, 
                cs.start_time, 
                cs.end_time, 
                cs.capacity, 
                c.image_url,
                c.description,
                c.name AS class_name, 
                COUNT(ce.id) AS total_enrolled
              FROM class_sessions cs
              INNER JOIN classes c ON cs.class_id = c.id
              LEFT JOIN class_enrollments ce 
                  ON cs.id = ce.class_session_id AND ce.status = 'enrolled'
              WHERE 
                  (cs.session_date > CURDATE() 
                   OR (cs.session_date = CURDATE() AND cs.end_time > CURTIME()))";

$params = [];
$types = "";

// Add search filter
if (!empty($search)) {
    $baseQuery .= " AND (c.name LIKE ? OR cs.session_date LIKE ?)";
    $types .= "ss";
    $params[] = &$searchTerm;
    $params[] = &$searchTerm;
}

// Exclude sessions the user is already enrolled in
if ($userId) {
    $baseQuery .= " AND NOT EXISTS (
                        SELECT 1 FROM class_enrollments ce2 
                        WHERE ce2.class_session_id = cs.id 
                        AND ce2.user_id = ? 
                        AND ce2.status = 'enrolled')";
    $types .= "i";
    $params[] = &$userId;
}

$baseQuery .= " GROUP BY cs.id ORDER BY cs.session_date DESC";

$stmt = $conn->prepare($baseQuery);

if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();

if (!$result) {
    die("Query failed: " . $conn->error);
}
