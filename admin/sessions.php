<?php
session_start();

// Check if the user is logged in and their role is admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit();
}

include "../processes/GET/getAllClasses.php";
include "../processes/GET/getEnrolledUsers.php";


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="stylesheet" href="../styles.css">
    <link rel="shortcut icon" href="../public/favicon.ico" type="image/x-icon">
    <title>Manage Class Sessions</title>
</head>

<body class="text-light">

    <!-- Navigation -->
    <nav class="navbar fixed-top navbar-expand-lg bg-dark px-4 py-3" data-bs-theme="dark">
        <div class="container-fluid">
            <!-- Logo and Brand Name -->
            <a class="navbar-brand d-flex align-items-center w-25" href="./../index.php">
                <img src="../public/blackwhite.svg" alt="Logo" width="50" height="50" class="me-3 rounded-circle">
                BeastModeHQ
            </a>
            <!-- Navbar Toggler -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
                aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Navbar Content -->
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <!-- Centered Navigation Links -->
                <div class="d-flex justify-content-lg-center justify-content-start w-100 ms-0 ms-lg-5 ms-xl-10">
                    <div class="navbar-nav">
                        <a class="nav-link" href="./dashboard.php">Dashboard</a>
                        <a class="nav-link" href="./memberships.php">Manage Memberships</a>
                        <a class="nav-link" href="./classes.php">Manage Classes</a>
                        <a class="nav-link active" aria-current="page" href="./sessions.php">Manage Class Sessions</a>
                    </div>
                </div>
                <!-- User Info or Login/Sign Up Buttons -->
                <div
                    class="row w-100 d-flex justify-content-center justify-content-lg-end align-items-center gap-3 gap-lg-0">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <div class="col-12 col-lg-auto">
                            <span class="text-light">
                                <strong><?php echo htmlspecialchars(ucwords(strtolower($_SESSION['user_name']))); ?></strong>
                        </div>
                        <div class="col-12 col-lg-auto">
                            <a class="btn btn-danger text-light px-3 w-100" href="../processes/process_logout.php" role="button">Logout</a>
                        </div>
                    <?php else: ?>
                        <div class="col-12 col-lg-auto">
                            <a class="btn btn-tertiary text-light px-3 w-100" href="auth/login.php" role="button">Login</a>
                        </div>
                        <div class="col-12 col-lg-auto">
                            <a class="btn btn-brand text-light px-3 w-100" href="auth/signup.php" type="button">Get
                                Started</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <main class="container mt-10">

        <h1 class="mb-4">Manage Class Sessions</h1>

        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo htmlspecialchars($_GET['success']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo htmlspecialchars($_GET['error']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="w-100 d-flex justify-content-between align-items-center mb-4">
            <!-- Search Form -->
            <form method="GET" action="sessions.php" class="mb-4 w-50 d-flex gap-2">
                <input type="text" class="form-control bg-dark text-light border-secondary rounded-3" name="search" placeholder="Search by class name or date" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                <button class="btn btn-light rounded-3" type="submit">Search</button>
                <a href="sessions.php" class="btn btn-secondary rounded-3">Clear</a>
            </form>
            <!-- Button to trigger modal -->
            <button type="button" class="btn btn-brand mb-4 text-light" data-bs-toggle="modal" data-bs-target="#addSessionModal">
                Add New Session
            </button>
        </div>

        <!-- Add Session Modal -->
        <div class="modal fade" id="addSessionModal" tabindex="-1" aria-labelledby="addSessionModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content bg-dark text-light">
                    <div class="modal-header bg-primary text-light">
                        <h5 class="modal-title text-light" id="addSessionModalLabel">Add New Session</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="../processes/POST/addSession.php" method="POST">
                            <div class="mb-3">
                                <label for="classId" class="form-label">Class Name</label>
                                <select class="form-select bg-dark text-light border-secondary" id="classId" name="class_id" required>
                                    <option value="" disabled selected>Select a class</option>
                                    <?php foreach ($classes as $class): ?>
                                        <option value="<?php echo $class['id']; ?>"><?php echo htmlspecialchars($class['name']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="sessionDate" class="form-label">Session Date</label>
                                <input type="date" class="form-control bg-dark text-light border-secondary" id="sessionDate" name="session_date" required>
                            </div>
                            <div class="mb-3">
                                <label for="startTime" class="form-label">Start Time</label>
                                <input type="time" class="form-control bg-dark text-light border-secondary" id="startTime" name="start_time" required>
                            </div>
                            <div class="mb-3">
                                <label for="endTime" class="form-label">End Time</label>
                                <input type="time" class="form-control bg-dark text-light border-secondary" id="endTime" name="end_time" required>
                            </div>
                            <div class="mb-3">
                                <label for="capacity" class="form-label">Capacity</label>
                                <input type="number" class="form-control bg-dark text-light border-secondary" id="capacity" name="capacity" value="20" required>
                            </div>
                            <div class="modal-footer border-secondary">
                                <button type="button" class="btn btn-secondary text-light" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success text-light">Add Session</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sessions Table -->
        <div class="card bg-dark text-light">
            <div class="card-header bg-secondary text-white">
                <h5>Class Sessions</h5>
            </div>
            <div class="card-body">
                <table class="table table-dark table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Class Name</th>
                            <th>Session Date</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Capacity</th>
                            <th>Total Enrolled</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        // Fetch class sessions from the database
                        include "../processes/GET/getAllSessions.php";

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr class='align-middle'>";
                                echo "<td>" . $row['id'] . "</td>";
                                echo "<td>" . htmlspecialchars($row['class_name']) . "</td>"; // Display class name
                                echo "<td>" . htmlspecialchars($row['session_date']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['start_time']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['end_time']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['capacity']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['total_enrolled']) . "</td>"; // Display total enrolled members
                                echo "<td>";
                                echo "<div class='d-flex gap-2' role='group'>";
                                // View Button (Offcanvas)
                                echo "<button type='button' class='btn btn-sm btn-purple' data-bs-toggle='offcanvas' data-bs-target='#viewSession" . $row['id'] . "' aria-controls='viewSession" . $row['id'] . "'>View</button>";
                                // Edit Button
                                echo "<button type='button' class='btn btn-sm btn-light' data-bs-toggle='modal' data-bs-target='#editSessionModal" . $row['id'] . "'>Edit</button>";
                                // Delete Button
                                echo "<form action='../processes/POST/deleteSession.php' method='POST' class='d-inline'>";
                                echo "<input type='hidden' name='session_id' value='" . $row['id'] . "'>";
                                echo "<button type='submit' class='btn btn-sm btn-danger'>Delete</button>";
                                echo "</form>";
                                echo "</div>";
                                echo "</td>";
                                echo "</tr>";


                                // Edit Session Modal
                                echo "<div class='modal fade' id='editSessionModal" . $row['id'] . "' tabindex='-1' aria-labelledby='editSessionModalLabel" . $row['id'] . "' aria-hidden='true'>";
                                echo "<div class='modal-dialog'>";
                                echo "<div class='modal-content bg-dark text-light'>";
                                echo "<div class='modal-header bg-primary text-light'>";
                                echo "<h5 class='modal-title text-light' id='editSessionModalLabel" . $row['id'] . "'>Edit Session</h5>";
                                echo "<button type='button' class='btn-close btn-close-white' data-bs-dismiss='modal' aria-label='Close'></button>";
                                echo "</div>";
                                echo "<div class='modal-body'>";
                                echo "<form action='../processes/POST/editSession.php' method='POST'>";
                                echo "<input type='hidden' name='session_id' value='" . $row['id'] . "'>";
                                echo "<div class='mb-3'>";
                                echo "<label for='classId" . $row['id'] . "' class='form-label'>Class Name</label>";
                                echo "<select class='form-select bg-dark text-light border-secondary' id='classId" . $row['id'] . "' name='class_id' required>";
                                foreach ($classes as $class) {
                                    $selected = $class['id'] == $row['class_id'] ? "selected" : "";
                                    echo "<option value='" . $class['id'] . "' $selected>" . htmlspecialchars($class['name']) . "</option>";
                                }
                                echo "</select>";
                                echo "</div>";
                                echo "<div class='mb-3'>";
                                echo "<label for='sessionDate" . $row['id'] . "' class='form-label'>Session Date</label>";
                                echo "<input type='date' class='form-control bg-dark text-light border-secondary' id='sessionDate" . $row['id'] . "' name='session_date' value='" . $row['session_date'] . "' required>";
                                echo "</div>";
                                echo "<div class='mb-3'>";
                                echo "<label for='startTime" . $row['id'] . "' class='form-label'>Start Time</label>";
                                echo "<input type='time' class='form-control bg-dark text-light border-secondary' id='startTime" . $row['id'] . "' name='start_time' value='" . $row['start_time'] . "' required>";
                                echo "</div>";
                                echo "<div class='mb-3'>";
                                echo "<label for='endTime" . $row['id'] . "' class='form-label'>End Time</label>";
                                echo "<input type='time' class='form-control bg-dark text-light border-secondary' id='endTime" . $row['id'] . "' name='end_time' value='" . $row['end_time'] . "' required>";
                                echo "</div>";
                                echo "<div class='mb-3'>";
                                echo "<label for='capacity" . $row['id'] . "' class='form-label'>Capacity</label>";
                                echo "<input type='number' class='form-control bg-dark text-light border-secondary' id='capacity" . $row['id'] . "' name='capacity' value='" . $row['capacity'] . "' required>";
                                echo "</div>";
                                echo "<div class='modal-footer border-secondary'>";
                                echo "<button type='button' class='btn btn-secondary text-light' data-bs-dismiss='modal'>Close</button>";
                                echo "<button type='submit' class='btn btn-success text-light'>Save Changes</button>";
                                echo "</div>";
                                echo "</form>";
                                echo "</div>";
                                echo "</div>";
                                echo "</div>";
                                echo "</div>";

                                // Offcanvas for Viewing Session Details
                                echo "<div class='offcanvas offcanvas-end bg-dark text-light' tabindex='-1' id='viewSession" . $row['id'] . "' aria-labelledby='viewSessionLabel" . $row['id'] . "'>";
                                echo "<div class='offcanvas-header bg-primary text-light'>";
                                echo "<h5 class='offcanvas-title' id='viewSessionLabel" . $row['id'] . "'>Session Details</h5>";
                                echo "<button type='button' class='btn-close btn-close-white' data-bs-dismiss='offcanvas' aria-label='Close'></button>";
                                echo "</div>";
                                echo "<div class='offcanvas-body'>";
                                echo "<h6>Class Name: " . htmlspecialchars($row['class_name']) . "</h6>";
                                echo "<p><strong>Session Date:</strong> " . htmlspecialchars($row['session_date']) . "</p>";
                                echo "<p><strong>Start Time:</strong> " . htmlspecialchars($row['start_time']) . "</p>";
                                echo "<p><strong>End Time:</strong> " . htmlspecialchars($row['end_time']) . "</p>";
                                echo "<p><strong>Capacity:</strong> " . htmlspecialchars($row['capacity']) . "</p>";
                                echo "<p><strong>Total Enrolled:</strong> " . htmlspecialchars($row['total_enrolled']) . "</p>";
                                echo "<hr>";
                                echo "<h6>Enrolled Members</h6>";
                                $enrolledUsers = getEnrolledUsers($row['id']); // Call the function
                                if (!empty($enrolledUsers)) {
                                    echo "<div class='list-group'>";
                                    foreach ($enrolledUsers as $index => $user) {
                                        // Determine badge color and button text based on status
                                        $badgeColor = $user['status'] === 'enrolled' ? 'bg-success' : 'bg-danger';
                                        $badgeText = ucfirst($user['status']); // Capitalize the status text
                                        $buttonText = $user['status'] === 'enrolled' ? 'Cancel' : 'Re-enroll';
                                        $buttonClass = $user['status'] === 'enrolled' ? 'btn-danger' : 'btn-light';
                                        $actionScript = $user['status'] === 'enrolled' ? '../processes/POST/cancelEnrollment.php' : '../processes/POST/reEnrollMember.php';

                                        echo "<div class='list-group-item bg-dark text-light d-flex justify-content-between align-items-center'>";
                                        echo "<div>";
                                        echo "<strong>" . ($index + 1) . ". " . htmlspecialchars($user['user_name']) . "</strong><br>";
                                        echo "<small class='text-secondary'>" . htmlspecialchars($user['user_email']) . "</small>";
                                        echo "</div>";
                                        echo "<span class='badge $badgeColor'>$badgeText</span>";
                                        echo "<form action='$actionScript' method='POST' class='d-inline'>";
                                        echo "<input type='hidden' name='enrollment_id' value='" . $user['enrollment_id'] . "'>";
                                        echo "<button type='submit' class='btn btn-sm $buttonClass'>$buttonText</button>";
                                        echo "</form>";
                                        echo "</div>";
                                    }
                                    echo "</div>";
                                } else {
                                    echo "<p class='text-secondary'>No members enrolled in this session.</p>";
                                }
                                echo "</div>";
                                echo "</div>";
                            }
                        } else {
                            echo "<tr><td colspan='7' class='text-center'>No sessions found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
</body>

</html>