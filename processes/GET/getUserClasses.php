<?php
function getUserClasses($userId) {
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
            cs.id AS session_id,
            c.name AS class_name,
            c.description AS class_description,
            c.image_url AS class_image,
            cs.session_date,
            cs.start_time,
            cs.end_time,
            ce.status
        FROM class_enrollments ce
        JOIN class_sessions cs ON ce.class_session_id = cs.id
        JOIN classes c ON cs.class_id = c.id
        WHERE ce.user_id = ? AND cs.session_date >= CURDATE()
        ORDER BY cs.session_date, cs.start_time
    ");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    $classSessions = [];
    while ($row = $result->fetch_assoc()) {
        $classSessions[] = $row;
    }

    $stmt->close();
    $conn->close();

    return $classSessions;
}
?>