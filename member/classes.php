<?php
session_start();

// Check if the user is logged in and their role is 'member'
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'member') {
    header("Location: ../auth/login.php");
    exit();
}

// Include database connection and helper functions
include "../processes/GET/getUserClasses.php";

// Fetch upcoming class sessions for the logged-in user
$userId = $_SESSION['user_id'];
$classSessions = getUserClasses($userId);
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
    <title>My Classes</title>
</head>

<body class="">

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
                        <a class="nav-link active" aria-current="page" href="./classes.php">My Classes</a>
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
        <h1 class="mb-4">My Upcoming Classes</h1>

        <!-- Alert messages -->
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

        <!-- Search and Add Class -->
        <div class="w-100 d-flex justify-content-between align-items-center mb-4">
            <!-- Search Form -->
            <form method="GET" action="classes.php" class="mb-4 w-50 d-flex gap-2">
                <input type="text" class="form-control bg-dark text-light border-secondary rounded-3" name="search"
                    placeholder="Search by class name"
                    value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                <button class="btn btn-purple rounded-3" type="submit">Search</button>
                <a href="classes.php" class="btn btn-outline-secondary rounded-3">Clear</a>
            </form>
            <!-- Button to trigger modal -->

            <a href="../classes.php" class="btn btn-light text-dark btn-sm px-3 py-2 d-flex gap-2"><i class="bi bi-plus-square text-dark"></i> Book a Class</a>
        </div>


        <?php if (!empty($classSessions)): ?>
            <div class="row">
                <?php foreach ($classSessions as $session): ?>
                    <div class="col-md-4 mb-4">

                        <div class="card bg-dark text-light">

                            <div class="card-body">
                                <img src="<?php echo htmlspecialchars($session['class_image'] ?? '../public/blackwhite.svg'); ?>"
                                    class="card-img-top my-3 rounded-2" style="height:250px; object-fit:cover"
                                    alt="<?php echo htmlspecialchars($session['class_name']); ?>">
                                <h5 class="card-title fs-3"><?php echo htmlspecialchars($session['class_name']); ?></h5>
                                <p class="card-text text-secondary">
                                    <?php echo htmlspecialchars($session['class_description']); ?>
                                </p>

                                <div class="d-flex align-items-center gap-2">
                                    <h6 class="text-secondary">Date:</h6>
                                    <h6><strong><?php echo htmlspecialchars(date("F j, Y", strtotime($session['session_date']))); ?></strong>
                                    </h6>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <h6 class="text-secondary">Time:</h6>
                                    <h6><strong><?php echo htmlspecialchars(date("g:i A", strtotime($session['start_time']))); ?>
                                            -
                                            <?php echo htmlspecialchars(date("g:i A", strtotime($session['end_time']))); ?></strong>
                                    </h6>

                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <h6 class="text-secondary">Status:</h6>
                                    <span class="badge 
                                <?php echo $session['status'] === 'enrolled' ? 'bg-success' : 'bg-danger'; ?>">
                                        <?php echo ucfirst($session['status']); ?>
                                    </span>
                                </div>

                                <!-- Cancel Enrollment Button -->
                                <?php if ($session['status'] === 'enrolled'): ?>
                                    <form method="POST" action="../processes/POST/cancelUserSessionEnrollment.php" class="mt-3">
                                        <input type="hidden" name="session_id"
                                            value="<?php echo htmlspecialchars($session['session_id']); ?>">
                                        <button type="submit" class="btn btn-danger w-100"
                                            onclick="return confirm('Are you sure you want to cancel this class? This action cannot be undone.');">
                                            Cancel Enrollment
                                        </button>
                                    </form>
                                <?php endif; ?>

                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-warning text-center" role="alert">
                You are not enrolled in any upcoming classes. <a href="../classes.php" class="alert-link">Enroll now</a>.
            </div>
        <?php endif; ?>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq"
        crossorigin="anonymous"></script>
</body>

</html>