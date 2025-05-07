<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "beastmodehq";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch total memberships
$queryTotalMemberships = "SELECT COUNT(*) AS total_memberships FROM memberships WHERE status = 'active'";
$resultTotalMemberships = $conn->query($queryTotalMemberships);
$totalMemberships = $resultTotalMemberships->fetch_assoc()['total_memberships'] ?? 0;

// Fetch ongoing class sessions
$queryOngoingSessions = "SELECT COUNT(*) AS ongoing_sessions FROM class_sessions WHERE session_date = CURDATE()";
$resultOngoingSessions = $conn->query($queryOngoingSessions);
$ongoingSessions = $resultOngoingSessions->fetch_assoc()['ongoing_sessions'] ?? 0;

// Fetch total enrollments
$queryTotalEnrollments = "SELECT COUNT(*) AS total_enrollments FROM class_enrollments WHERE status = 'enrolled'";
$resultTotalEnrollments = $conn->query($queryTotalEnrollments);
$totalEnrollments = $resultTotalEnrollments->fetch_assoc()['total_enrollments'] ?? 0;

// Fetch total classes
$queryTotalClasses = "SELECT COUNT(*) AS total_classes FROM classes";
$resultTotalClasses = $conn->query($queryTotalClasses);
$totalClasses = $resultTotalClasses->fetch_assoc()['total_classes'] ?? 0;

// Fetch average enrollment per class session
$queryAverageEnrollment = "
    SELECT AVG(enrollment_count) AS average_enrollment
    FROM (
        SELECT COUNT(class_enrollments.id) AS enrollment_count
        FROM class_sessions
        LEFT JOIN class_enrollments ON class_sessions.id = class_enrollments.class_session_id
        GROUP BY class_sessions.id
    ) AS session_enrollments";
$resultAverageEnrollment = $conn->query($queryAverageEnrollment);
$averageEnrollment = round($resultAverageEnrollment->fetch_assoc()['average_enrollment'] ?? 0, 2);

// Fetch the most popular class
$queryPopularClass = "
        SELECT classes.name AS class_name, COUNT(class_enrollments.id) AS total_enrollments
        FROM class_enrollments
        INNER JOIN class_sessions ON class_enrollments.class_session_id = class_sessions.id
        INNER JOIN classes ON class_sessions.class_id = classes.id
        GROUP BY classes.id
        ORDER BY total_enrollments DESC
        LIMIT 1";
$resultPopularClass = $conn->query($queryPopularClass);
$popularClass = $resultPopularClass->fetch_assoc();
$mostPopularClass = $popularClass['class_name'] ?? 'N/A';
$mostPopularClassEnrollments = $popularClass['total_enrollments'] ?? 0;

// Close the database connection
$conn->close();
