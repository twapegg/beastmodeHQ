<?php
session_start();

// Check if the user is logged in and their role is 'member'
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'member') {
    header("Location: ../auth/login.php");
    exit();
}

include "../processes/POST/applyMembership.php";

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

    <?php include "../components/navbarMember.php" ?>

    <main class="container mt-10">
        <h1 class="mb-4">Apply for Membership</h1>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <section class="pricing section container mt-10">
            <h1 class="text-center mb-5 text-light">Choose Your Membership Plan</h1>
            <form method="POST" action="apply.php">
                <div class="row text-center">
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm bg-dark text-light">
                            <div class="card-body d-flex flex-column p-4">
                                <h5 class="card-title mt-3">Weekly Membership</h5>
                                <p class="card-text text-secondary">Perfect for short-term commitments.</p>
                                <h2 class="text-info">₱499/week</h2>
                                <ul class="list-unstyled mt-3 mb-4">
                                    <li>Access to gym equipment</li>
                                    <li>1 fitness class per week</li>
                                    <li>Locker room access</li>
                                </ul>
                                <button type="submit" name="membership_type" value="weekly" class="btn btn-primary mt-auto">Choose Plan</button>
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
                                <button type="submit" name="membership_type" value="monthly" class="btn btn-success mt-auto">Choose Plan</button>
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
                                <button type="submit" name="membership_type" value="yearly" class="btn btn-warning mt-auto">Choose Plan</button>
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