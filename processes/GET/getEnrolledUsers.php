<?php

function getEnrolledUsers($session_id) {
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

    // Fetch enrolled users for a specific session
    $query = "SELECT 
                class_enrollments.id AS enrollment_id, 
                users.id AS user_id, 
                users.name AS user_name, 
                users.email AS user_email, 
                class_enrollments.status, 
                class_enrollments.enrolled_at
              FROM class_enrollments
              INNER JOIN users ON class_enrollments.user_id = users.id
              WHERE class_enrollments.class_session_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $session_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Store the results in an array
    $enrolledUsers = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $enrolledUsers[] = $row;
        }
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();

    return $enrolledUsers;
}