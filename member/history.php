<?php
session_start();

// Check if the user is logged in and their role is 'member'
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'member') {
    header("Location: ../auth/login.php");
    exit();
}

// Include database connection and helper functions
include "../processes/GET/getEnrollmentHistory.php";

// Fetch enrollment history for the logged-in user
$userId = $_SESSION['user_id'];
$enrollmentHistory = getEnrollmentHistory($userId);
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
    <title>Enrollment History</title>
</head>

<body class="text-light">

    <!-- Navigation -->
    <nav class="navbar fixed-top navbar-expand-lg bg-dark bg-gradient px-4 py-3" data-bs-theme="dark">
        <div class="container-fluid">
            <!-- Logo and Brand Name -->
            <a class="navbar-brand d-flex align-items-center w-25" href="../index.php">
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
                        <a class="nav-link" href="./membership.php">My Membership</a>
                        <a class="nav-link" href="./classes.php">My Classes</a>
                        <a class="nav-link active" aria-current="page" href="./history.php">Enrollment History</a>
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
                            <a class="btn btn-tertiary text-light px-3 w-100" href="../auth/login.php" role="button">Login</a>
                        </div>
                        <div class="col-12 col-lg-auto">
                            <a class="btn btn-brand text-light px-3 w-100" href="../auth/signup.php" type="button">Get
                                Started</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <main class="container mt-10">
        <h1 class="mb-4">Enrollment History</h1>

        <?php if (!empty($enrollmentHistory)): ?>
            <div class="table-responsive rounded-3">
                <table class="table table-dark table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Class Name</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Status</th>
                            <th>Enrolled At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($enrollmentHistory as $history): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($history['class_name']); ?></td>
                                <td><?php echo htmlspecialchars(date("F j, Y", strtotime($history['session_date']))); ?></td>
                                <td><?php echo htmlspecialchars(date("g:i A", strtotime($history['start_time'])) . " - " . date("g:i A", strtotime($history['end_time']))); ?></td>
                                <td>
                                    <span class="badge 
                                        <?php echo $history['status'] === 'enrolled' ? 'bg-success' : ($history['status'] === 'cancelled' ? 'bg-danger' : 'bg-secondary'); ?>">
                                        <?php echo ucfirst($history['status']); ?>
                                    </span>
                                </td>
                                <td><?php echo htmlspecialchars(date("F j, Y, g:i A", strtotime($history['enrolled_at']))); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-warning text-center" role="alert">
                You have no enrollment history. <a href="./classes.php" class="alert-link">View available classes</a>.
            </div>
        <?php endif; ?>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
</body>

</html>