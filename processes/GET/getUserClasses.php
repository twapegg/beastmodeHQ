<?php
function getUserClasses($userId, $search = null) {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "beastmodehq";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Base query
    $query = "
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
    ";

    // Add search filter if a search term is provided
    if (!empty($search)) {
        $query .= " AND c.name LIKE ?";
    }

    $query .= " ORDER BY cs.session_date, cs.start_time";

    $stmt = $conn->prepare($query);

    if (!empty($search)) {
        $searchTerm = "%" . $search . "%";
        $stmt->bind_param("is", $userId, $searchTerm);
    } else {
        $stmt->bind_param("i", $userId);
    }

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