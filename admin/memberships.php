<?php
session_start();

// Check if the user is logged in and their role is admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    // Redirect to the login page or an error page
    header("Location: ../auth/login.php");
    exit();
}

// Fetch memberships from the database
include "../processes/GET/getAllMembers.php";
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
    <title>Manage Memberships</title>
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
                        <a class="nav-link active" aria-current="page" href="./memberships.php">Manage Memberships</a>
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

    <main class="container my-10">


        <h1 class="mb-4">Manage Memberships</h1>

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
            <!-- Search Form -->
            <form method="GET" action="memberships.php" class="mb-4 w-50 d-flex gap-2">
                <input type="text" class="form-control bg-dark text-light border-secondary rounded-3" name="search" placeholder="Search by name or email" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                <button class="btn btn-light rounded-3" type="submit">Search</button>
                <a href="memberships.php" class="btn btn-secondary rounded-3">Clear</a>
            </form>
            <!-- Button to trigger modal -->
            <button type="button" class="btn btn-brand mb-4 text-light" data-bs-toggle="modal" data-bs-target="#addMembershipModal">
                Add New Membership
            </button>
        </div>

        <!-- Add Membership Modal -->
        <div class="modal fade" id="addMembershipModal" tabindex="-1" aria-labelledby="addMembershipModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content bg-dark text-light">
                    <div class="modal-header bg-primary text-light">
                        <h5 class="modal-title text-light" id="addMembershipModalLabel">Add New Membership</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="../processes/POST/addMember.php" method="POST">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control bg-dark text-light border-secondary" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="membershipType" class="form-label">Membership Type</label>
                                <select class="form-select bg-dark text-light border-secondary" id="membershipType" name="membership_type" required>
                                    <option value="weekly">Weekly</option>
                                    <option value="monthly">Monthly</option>
                                    <option value="yearly">Yearly</option>
                                </select>
                            </div>
                            <div class="modal-footer border-secondary">
                                <button type="button" class="btn btn-secondary text-light" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success text-light">Add Membership</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Memberships Table -->
        <div class="card bg-dark text-light">
            <div class="card-header bg-secondary text-white">
                <h5>Memberships</h5>
            </div>
            <div class="card-body">
                <table class="table table-dark table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>User Name</th>
                            <th>Email</th>
                            <th>Membership Type</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr class='align-middle'>";
                                echo "<td>" . $row['id'] . "</td>";
                                echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                                echo "<td>" . htmlspecialchars(ucfirst($row['membership_type'])) . "</td>";
                                echo "<td>" . htmlspecialchars($row['start_date']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['end_date']) . "</td>";
                                echo "<td><span class='badge " .
                                    ($row['status'] === 'active' ? 'bg-success' : ($row['status'] === 'pending' ? 'bg-warning' : ($row['status'] === 'expired' ? 'bg-secondary' : ($row['status'] === 'canceled' ? 'bg-danger' : '')))) . "'>" . ucfirst($row['status']) . "</span></td>";
                                echo "<td>";

                                // Actions based on status
                                if ($row['status'] === 'active') {
                                    echo "<div class='d-flex gap-2' role='group'>";
                                    // Renew Button
                                    echo "<form action='../processes/POST/renewMember.php' method='POST' class='d-inline'>";
                                    echo "<input type='hidden' name='membership_id' value='" . $row['id'] . "'>";
                                    echo "<button type='submit' class='btn btn-sm btn-success text-light'>Renew</button>";
                                    echo "</form>";
                                    // Cancel Button
                                    echo "<form action='../processes/POST/cancelMember.php' method='POST' class='d-inline'>";
                                    echo "<input type='hidden' name='membership_id' value='" . $row['id'] . "'>";
                                    echo "<button type='submit' class='btn btn-sm btn-danger'>Cancel</button>";
                                    echo "</form>";
                                    echo "</div>";
                                } elseif ($row['status'] === 'pending') {
                                    echo "<div class='d-flex gap-2' role='group'>";
                                    // Approve Button
                                    echo "<form action='../processes/POST/renewMember.php' method='POST' class='d-inline'>";
                                    echo "<input type='hidden' name='membership_id' value='" . $row['id'] . "'>";
                                    echo "<button type='submit' class='btn btn-sm btn-brand text-light'>Approve</button>";
                                    echo "</form>";
                                    // Delete Button
                                    echo "<form action='../processes/POST/deleteMember.php' method='POST' class='d-inline'>";
                                    echo "<input type='hidden' name='membership_id' value='" . $row['id'] . "'>";
                                    echo "<button type='submit' class='btn btn-sm btn-outline-danger'>Reject</button>";
                                    echo "</form>";
                                    echo "</div>";
                                } elseif ($row['status'] === 'expired') {
                                    echo "<div class='d-flex gap-2' role='group'>";
                                    // Renew Button
                                    echo "<form action='../processes/POST/renewMember.php' method='POST' class='d-inline'>";
                                    echo "<input type='hidden' name='membership_id' value='" . $row['id'] . "'>";
                                    echo "<button type='submit' class='btn btn-sm btn-outline-success'>Renew</button>";
                                    echo "</form>";
                                    // Delete Button
                                    echo "<form action='../processes/POST/deleteMember.php' method='POST' class='d-inline'>";
                                    echo "<input type='hidden' name='membership_id' value='" . $row['id'] . "'>";
                                    echo "<button type='submit' class='btn btn-sm btn-danger'>Delete</button>";
                                    echo "</form>";
                                    echo "</div>";
                                } elseif ($row['status'] === 'canceled') {
                                    echo "<div class='d-flex gap-2' role='group'>";
                                    // Renew
                                    echo "<form action='../processes/POST/renewMember.php' method='POST' class='d-inline'>";
                                    echo "<input type='hidden' name='membership_id' value='" . $row['id'] . "'>";
                                    echo "<button type='submit' class='btn btn-sm btn-outline-success '>Renew</button>";
                                    echo "</form>";
                                    // Delete Button
                                    echo "<form action='../processes/POST/deleteMember.php' method='POST' class='d-inline'>";
                                    echo "<input type='hidden' name='membership_id' value='" . $row['id'] . "'>";
                                    echo "<button type='submit' class='btn btn-sm btn-danger'>Delete</button>";
                                    echo "</form>";
                                    echo "</div>";
                                }
                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='8' class='text-center'>No memberships found</td></tr>";
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