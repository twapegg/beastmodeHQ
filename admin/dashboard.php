<?php
session_start();

// Check if the user is logged in and their role is admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit();
}

include "../processes/GET/adminDashboard.php"
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="stylesheet" href="../styles.css">
    <link rel="shortcut icon" href="../public/favicon.ico" type="image/x-icon">
    <title>Admin Dashboard</title>
</head>

<body>

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
                        <a class="nav-link active" aria-current="page" href="./dashboard.php">Dashboard</a>
                        <a class="nav-link" href="./memberships.php">Manage Memberships</a>
                        <a class="nav-link" href="./classes.php">Manage Classes</a>
                        <a class="nav-link" href="./sessions.php">Manage Class Sessions</a>
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
        <h1 class="mb-4">Admin Dashboard</h1>
        <div class="row g-4">
            <!-- Total Active Memberships -->
            <div class="col-md-4">
                <div class="card text-white bg-primary">
                    <div class="card-body">
                        <h5 class="card-title">Active Memberships</h5>
                        <p class="card-text fs-4"><?php echo $totalMemberships; ?></p>
                        <i class="bi bi-person-plus fs-1"></i>
                    </div>
                </div>
            </div>

            <!-- Ongoing Class Sessions -->
            <div class="col-md-4">
                <div class="card text-white bg-success">
                    <div class="card-body">
                        <h5 class="card-title">Ongoing Class Sessions</h5>
                        <p class="card-text fs-4"><?php echo $ongoingSessions; ?></p>
                        <i class="bi bi-calendar-event fs-1"></i>
                    </div>
                </div>
            </div>

            <!-- Most Popular Class -->
            <div class="col-md-4">
                <div class="card text-white bg-purple">
                    <div class="card-body">
                        <h5 class="card-title">Most Popular Class</h5>
                        <p class="card-text fs-5"><?php echo htmlspecialchars($mostPopularClass) . " (" . $mostPopularClassEnrollments . " enrollees)"; ?></p>
                        <i class="bi bi-star-fill fs-1"></i>
                    </div>
                </div>
            </div>

            <!-- Total Enrollments -->
            <div class="col-md-4">
                <div class="card text-white bg-warning">
                    <div class="card-body">
                        <h5 class="card-title">Total Enrollments</h5>
                        <p class="card-text fs-4"><?php echo $totalEnrollments; ?></p>
                        <i class="bi bi-people fs-1"></i>
                    </div>
                </div>
            </div>

            <!-- Total Classes -->
            <div class="col-md-4">
                <div class="card text-white bg-info">
                    <div class="card-body">
                        <h5 class="card-title">Total Classes</h5>
                        <p class="card-text fs-4"><?php echo $totalClasses; ?></p>
                        <i class="bi bi-journal-bookmark fs-1"></i>
                    </div>
                </div>
            </div>

            <!-- Average Enrollment per Class Session -->
            <div class="col-md-4">
                <div class="card text-white bg-secondary">
                    <div class="card-body">
                        <h5 class="card-title">Average Enrollment per Class Session</h5>
                        <p class="card-text fs-4"><?php echo $averageEnrollment; ?></p>
                        <i class="bi bi-bar-chart-line fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </main>

</body>

</html>