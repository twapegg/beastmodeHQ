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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="stylesheet" href="../styles.css">
    <link rel="shortcut icon" href="../public/favicon.ico" type="image/x-icon">
    <title>My Classes</title>
</head>

<body class="">

    <?php include "../components/navbarMember.php" ?>

    <main class="container mt-10">
        <h1 class="mb-4">My Upcoming Classes</h1>

        <?php if (!empty($classSessions)): ?>
            <div class="row">
                <?php foreach ($classSessions as $session): ?>
                    <div class="col-md-4 mb-4">

                        <div class="card bg-dark text-light">
                            <div class="card-header bg-info text-light">
                                <h5 class="mb-0"><?php echo htmlspecialchars($session['class_name']); ?></h5>
                            </div>
                            <div class="card-body">
                                <img src="<?php echo htmlspecialchars($session['image_url'] ?? '../images/pilates.png'); ?>"
                                    class="card-img-top my-3" style="height:250px; object-fit:cover" alt="<?php echo htmlspecialchars($session['class_name']); ?>">
                                <div class="d-flex align-items-center gap-2">
                                    <h6 class="text-secondary">Date:</h6>
                                    <h6><strong><?php echo htmlspecialchars(date("F j, Y", strtotime($session['session_date']))); ?></strong></h6>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <h6 class="text-secondary">Time:</h6>
                                    <h6><strong><?php echo htmlspecialchars(date("g:i A", strtotime($session['start_time']))); ?> - <?php echo htmlspecialchars(date("g:i A", strtotime($session['end_time']))); ?></strong></h6>

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
                                        <input type="hidden" name="session_id" value="<?php echo htmlspecialchars($session['session_id']); ?>">
                                        <button type="submit" class="btn btn-danger w-100">Cancel Enrollment</button>
                                    </form>
                                <?php endif; ?>

                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-warning text-center" role="alert">
                You are not enrolled in any upcoming classes. <a href="./enroll.php" class="alert-link">Enroll now</a>.
            </div>
        <?php endif; ?>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
</body>

</html>