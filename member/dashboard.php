<?php
session_start();

// Check if the user is logged in and their role is 'member'
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'member') {
    header("Location: ../auth/login.php");
    exit();
}

include "../processes/GET/memberDashboard.php";
include_once "../processes/GET/getMembershipDetails.php";
$membership = getMembershipDetails($_SESSION['user_id']);
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
    <title>BeastModeHQ Member Dashboard</title>
</head>

<body class=" text-light">

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
                        <a class="nav-link active" aria-current="page" href="./dashboard.php">Dashboard</a>
                        <a class="nav-link" href="./membership.php">My Membership</a>
                        <a class="nav-link" href="./classes.php">My Classes</a>
                        <a class="nav-link" href="./history.php">Enrollment History</a>
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
        <h1 class="mb-4">Welcome back, <?php echo htmlspecialchars(ucwords(strtolower($_SESSION['user_name']))); ?>!</h1>

        <!-- Dashboard Summary Cards -->
        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="card text-white bg-purple h-100 shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title">Upcoming Classes</h5>
                        <p class="card-text fs-4"><?php echo $upcomingClassesCount; ?></p>
                        <i class="bi bi-calendar-event fs-1"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-success h-100 shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title">Sessions This Month</h5>
                        <p class="card-text fs-4"><?php echo $sessionsThisMonth; ?></p>
                        <i class="bi bi-calendar3 fs-1"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-warning h-100 shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title">Attendance Rate</h5>
                        <p class="card-text fs-4"><?php echo $attendanceRate; ?>%</p>
                        <i class="bi bi-graph-up fs-1"></i>
                    </div>
                </div>
            </div>
        </div>


        <!-- Upcoming Classes -->
        <div class="row g-4 mb-5">
            <!-- Upcoming Classes -->
            <div class="col-lg-8">
                <div class="card bg-gradient bg-dark shadow-sm border-0 h-100" style="min-height: 340px;">
                    <div class="card-header bg-gradient bg-primary d-flex align-items-center justify-content-between border-0 py-2">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-lightning-charge-fill text-light me-2"></i>
                            <h5 class="mb-0 text-light">Upcoming Classes</h5>
                        </div>
                        <a href="classes.php" class="btn btn-light text-dark btn-sm px-3 py-2 d-flex gap-2"><i class="bi bi-plus-square"></i> Book a Class</a>
                    </div>
                    <div class="card-body py-2 px-2 ">
                        <?php if (!empty($upcomingClassesList)): ?>
                            <ul class="list-group list-group-flush">
                                <?php foreach ($upcomingClassesList as $class): ?>
                                    <li class="list-group-item bg-dark text-light d-flex justify-content-between align-items-center py-3 border-0 rounded-3">
                                        <div class="d-flex align-items-center gap-2">
                                            <strong><?php echo htmlspecialchars($class['class_name']); ?></strong>
                                            <span class="text-secondary ms-2"><i class="bi bi-calendar2-week"></i> <?php echo htmlspecialchars(date("M j", strtotime($class['session_date']))); ?></span>
                                            <span class="text-secondary ms-2"><i class="bi bi-clock"></i> <?php echo htmlspecialchars(date("g:i A", strtotime($class['start_time']))); ?></span>
                                        </div>
                                        <span class="badge <?php
                                                            echo $class['status'] === 'enrolled' ? 'bg-success' : ($class['status'] === 'pending' ? 'bg-warning text-dark' : 'bg-secondary');
                                                            ?>"><?php echo ucfirst($class['status']); ?></span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <div class="alert alert-info mb-0 rounded-0">No upcoming classes. <a href="classes.php" class="alert-link">Enroll now</a>.</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Recent Attendance Summary -->
            <div class="col-lg-4">
                <div class="card bg-dark shadow-sm border-0 h-100">
                    <div class="card-header bg-info text-white d-flex align-items-center border-0 py-3">
                        <i class="bi bi-clock-history me-2"></i>
                        <h5 class="mb-0">Recent Attendance</h5>
                    </div>
                    <div class="card-body p-0">
                        <?php if (!empty($recentAttendance)): ?>
                            <ul class="list-group list-group-flush">
                                <?php foreach ($recentAttendance as $att): ?>
                                    <li class="list-group-item bg-dark text-light d-flex justify-content-between align-items-center py-2 border-0 border-bottom">
                                        <div>
                                            <strong><?php echo htmlspecialchars($att['class_name']); ?></strong>
                                            <span class="text-secondary ms-2"><?php echo htmlspecialchars(date("M j", strtotime($att['session_date']))); ?></span>
                                        </div>
                                        <span class="badge 
                                            <?php
                                            if ($att['status'] === 'attended') echo 'bg-success';
                                            elseif ($att['status'] === 'missed') echo 'bg-danger';
                                            elseif ($att['status'] === 'cancelled') echo 'bg-secondary';
                                            else echo 'bg-warning text-dark';
                                            ?>">
                                            <?php echo ucfirst($att['status']); ?>
                                        </span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <div class="alert alert-info mb-0 rounded-0">No recent attendance records.</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>


        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq"
        crossorigin="anonymous"></script>
</body>

</html>