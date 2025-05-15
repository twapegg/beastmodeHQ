<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "beastmodehq";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$userId = $_SESSION['user_id'];

// Upcoming classes count
$stmt = $conn->prepare("
    SELECT COUNT(*) AS cnt
    FROM class_enrollments ce
    JOIN class_sessions cs ON ce.class_session_id = cs.id
    WHERE ce.user_id = ? AND ce.status = 'enrolled' AND cs.session_date >= CURDATE()
");
$stmt->bind_param("i", $userId);
$stmt->execute();
$stmt->bind_result($upcomingClassesCount);
$stmt->fetch();
$stmt->close();

// Sessions this month
$stmt = $conn->prepare("
    SELECT COUNT(*) AS cnt
    FROM class_enrollments ce
    JOIN class_sessions cs ON ce.class_session_id = cs.id
    WHERE ce.user_id = ? AND ce.status = 'enrolled' AND MONTH(cs.session_date) = MONTH(CURDATE()) AND YEAR(cs.session_date) = YEAR(CURDATE())
");
$stmt->bind_param("i", $userId);
$stmt->execute();
$stmt->bind_result($sessionsThisMonth);
$stmt->fetch();
$stmt->close();

// Attendance rate 
$stmt = $conn->prepare("
    SELECT 
        SUM(CASE WHEN status = 'present' THEN 1 ELSE 0 END) AS present_count,
        COUNT(*) AS total_count
    FROM attendance
    WHERE user_id = ?
");
$stmt->bind_param("i", $userId);
$stmt->execute();
$stmt->bind_result($presentCount, $totalAttendance);
$stmt->fetch();
$stmt->close();
$attendanceRate = ($totalAttendance > 0) ? round(($presentCount / $totalAttendance) * 100, 1) : 0;

// Recent Attendance (last 5 from attendance table)
$stmt = $conn->prepare("
    SELECT c.name AS class_name, cs.session_date, a.status
    FROM attendance a
    JOIN class_sessions cs ON a.class_session_id = cs.id
    JOIN classes c ON cs.class_id = c.id
    WHERE a.user_id = ?
    ORDER BY a.attendance_time DESC
    LIMIT 5
");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$recentAttendance = [];
while ($row = $result->fetch_assoc()) {
    $recentAttendance[] = [
        'class_name' => $row['class_name'],
        'session_date' => $row['session_date'],
        // Map attendance.status to dashboard badge/status
        'status' => ($row['status'] === 'present' ? 'attended' : ($row['status'] === 'absent' ? 'missed' : 'late'))
    ];
}
$stmt->close();


// Next 5 upcoming classes
$stmt = $conn->prepare("
    SELECT c.name AS class_name, cs.session_date, cs.start_time, ce.status
    FROM class_enrollments ce
    JOIN class_sessions cs ON ce.class_session_id = cs.id
    JOIN classes c ON cs.class_id = c.id
    WHERE ce.user_id = ? AND cs.session_date >= CURDATE()
    ORDER BY cs.session_date, cs.start_time
    LIMIT 5
");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$upcomingClassesList = [];
while ($row = $result->fetch_assoc()) {
    $upcomingClassesList[] = $row;
}
$stmt->close();

$conn->close();
