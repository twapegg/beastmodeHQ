<?php
session_start();

// Check if the user is logged in and their role is 'member'
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'member') {
    header("Location: ../auth/login.php");
    exit();
}

include "../processes/POST/applyMembership.php";

// Include the function
include "../processes/GET/getMembershipDetails.php";

$userId = $_SESSION['user_id'];
$membership = getMembershipDetails($userId);

// If there's an active, pending, or canceled (still in grace period) membership, restrict access
if ($membership && in_array($membership['status'], ['active', 'pending', 'canceled'])) {
    header("Location: ../member/membership.php?error=already_has_membership");
    exit();
}
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
    <title>Apply for Membership</title>
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
                        <a class="nav-link active" aria-current="page" href="./membership.php">My Membership</a>
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
        <h1 class="mb-3">Apply for Membership</h1>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <section class="pricing section container mt-5">
            <h1 class="text-center mb-5 text-light">Choose Your Membership Plan</h1>
            <form method="POST" action="apply.php">
                <div class="row text-center">
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm bg-dark text-light">
                            <div class="card-body d-flex flex-column p-4">
                                <h5 class="card-title mt-3">Weekly Membership</h5>
                                <p class="card-text text-secondary">Perfect for short-term commitments.</p>
                                <h2 class="text-purple">₱499/week</h2>
                                <ul class="list-unstyled mt-3 mb-4">
                                    <li>Access to gym equipment</li>
                                    <li>1 fitness class per week</li>
                                    <li>Locker room access</li>
                                </ul>
                                <button type="submit" name="membership_type" value="weekly" class="btn btn-purple mt-auto"
                                    onclick="return confirm('Are you sure you want to choose the Weekly Membership plan?');">
                                    Choose Plan
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm bg-dark text-light">
                            <div class="card-body d-flex flex-column p-4">
                                <h5 class="card-title mt-3">Monthly Membership</h5>
                                <p class="card-text text-secondary">Ideal for regular gym-goers.</p>
                                <h2 class="text-success">₱1,499/month</h2>
                                <ul class="list-unstyled mt-3 mb-4">
                                    <li>Unlimited gym access</li>
                                    <li>3 fitness classes per week</li>
                                    <li>Free nutrition counseling</li>
                                </ul>
                                <button type="submit" name="membership_type" value="monthly" class="btn btn-success mt-auto"
                                    onclick="return confirm('Are you sure you want to choose the Monthly Membership plan?');">
                                    Choose Plan
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm bg-dark text-light">
                            <div class="card-body d-flex flex-column p-4">
                                <h5 class="card-title mt-3">Yearly Membership</h5>
                                <p class="card-text text-secondary">Best value for long-term commitment.</p>
                                <h2 class="text-warning">₱14,999/year</h2>
                                <ul class="list-unstyled mt-3 mb-4">
                                    <li>Unlimited gym access</li>
                                    <li>Unlimited fitness classes</li>
                                    <li>Access to spa services</li>
                                    <li>Personal trainer sessions</li>
                                </ul>
                                <button type="submit" name="membership_type" value="yearly" class="btn btn-warning mt-auto"
                                    onclick="return confirm('Are you sure you want to choose the Yearly Membership plan?');">
                                    Choose Plan
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </section>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
</body>

</html>