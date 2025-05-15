<?php
session_start();

// Check if the user is logged in and their role is 'member'
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'member') {
    header("Location: ../auth/login.php");
    exit();
}

// Include database connection
include "../processes/GET/getMembershipDetails.php";
include "../processes/POST/updateMembershipStatus.php"; // For handling cancel/renew actions

// Fetch membership details for the logged-in user
$userId = $_SESSION['user_id'];
$membership = getMembershipDetails($userId);

// Handle cancel or renew actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['cancel_membership'])) {
        updateMembershipStatus($membership['id'], 'canceled');
        header("Location: membership.php?success=Membership cancelled successfully!");
        exit();
    } elseif (isset($_POST['renew_membership'])) {
        updateMembershipStatus($membership['id'], 'pending');
        header("Location: membership.php?success=Membership renewed successfully!");
        exit();
    }
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
    <title>My Membership</title>
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
        <h1 class="mb-4">My Membership</h1>

        <!-- Display Bootstrap Alert -->
        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo htmlspecialchars($_GET['success']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>


        <?php if ($membership): ?>
            <div class="card bg-dark text-light ">
                <div class="card-header d-flex bg-purple text-white py-3 pb-2 align-items-center bg-gradient">
                    <h5>Membership Details</h5>
                </div>
                <div class="card-body py-4">
                    <div class="row mb-4">
                        <div class="col-md-6 d-flex gap-2 align-items-center ">
                            <h6 class="text-secondary">Member Name:</h6>
                            <h6><strong><?php echo htmlspecialchars(ucwords(strtolower($_SESSION['user_name']))); ?></strong></h6>
                        </div>
                        <div class="col-md-6 d-flex gap-2 align-items-center ">
                            <h6 class="text-secondary">Membership ID: </h6>
                            <h6><strong><?php echo htmlspecialchars($membership['id']); ?></strong></h6>
                        </div>
                        <div class="col-md-6 d-flex gap-2 align-items-center ">
                            <h6 class="text-secondary">Membership Type:</h6>
                            <h6><strong> <?php echo ucfirst($membership['membership_type']); ?></strong></h6>
                        </div>
                        <div class="col-md-6 d-flex gap-2 align-items-center ">
                            <h6 class="text-secondary">Status:</h6>
                            <h6><strong>
                                    <span class="badge 
                                <?php echo $membership['status'] === 'active' ? 'bg-success' : ($membership['status'] === 'expired' ? 'bg-secondary' : ($membership['status'] === 'pending' ? 'bg-warning' : 'bg-danger')); ?>">
                                        <?php echo ucfirst($membership['status']); ?>
                                    </span>
                                </strong>
                            </h6>
                        </div>
                        <div class="col-md-6 d-flex gap-2 align-items-center ">
                            <h6 class="text-secondary">Start Date:</h6>
                            <h6><strong> <?php echo htmlspecialchars(date('F j, Y', strtotime($membership['start_date']))); ?></strong></h6>
                        </div>
                        <div class="col-md-6 d-flex gap-2 align-items-center ">
                            <h6 class="text-secondary">End Date:</h6>
                            <h6><strong> <?php echo htmlspecialchars(date('F j, Y', strtotime($membership['end_date']))); ?></strong></h6>
                        </div>
                    </div>



                    <!-- Cancel or Renew Buttons -->
                    <form method="POST" class="mt-4">
                        <?php if ($membership['status'] === 'active' || $membership['status'] === 'pending'): ?>
                            <button type="submit" name="cancel_membership" class="btn btn-danger">Cancel Membership</button>
                        <?php elseif ($membership['status'] === 'canceled' || $membership['status'] === 'expired'): ?>
                            <button type="submit" name="renew_membership" class="btn btn-success">Renew Membership</button>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
        <?php else: ?>
            <div class="alert alert-warning text-center" role="alert">
                You do not have an active membership. <a href="./apply.php" class="alert-link">Join now</a>.
            </div>
        <?php endif; ?>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
</body>

</html>