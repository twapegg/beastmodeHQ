<?php
function getEnrollmentHistory($userId) {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "beastmodehq";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("
        SELECT 
            c.name AS class_name,
            cs.session_date,
            cs.start_time,
            cs.end_time,
            ce.status,
            ce.enrolled_at
        FROM class_enrollments ce
        JOIN class_sessions cs ON ce.class_session_id = cs.id
        JOIN classes c ON cs.class_id = c.id
        WHERE ce.user_id = ?
        ORDER BY ce.enrolled_at DESC
    ");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    $history = [];
    while ($row = $result->fetch_assoc()) {
        $history[] = $row;
    }

    $stmt->close();
    $conn->close();

    return $history;
}
?>