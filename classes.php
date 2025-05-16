<?php
session_start();

$userId = $_SESSION['user_id'] ?? null;



?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
    <link rel="shortcut icon" href="./public/favicon.ico" type="image/x-icon">
    <title>Classes - BeastModeHQ</title>
</head>

<body>

    <!-- Navigation -->
    <nav class="navbar fixed-top navbar-expand-lg bg-primary bg-opacity-25 px-4 py-3" data-bs-theme="dark">
        <div class="container-fluid">
            <div class="w-25 d-flex  align-items-center gap-3">

                <!-- Logo and Brand Name -->
                <a class="navbar-brand d-flex align-items-center" href="index.php">
                    <img src="./public/blackwhite.svg" alt="Logo" width="50" height="50" class="me-3 rounded-circle">
                    BeastModeHQ
                </a>

                <?php if (isset($_SESSION['user_role'])): ?>
                    <?php if ($_SESSION['user_role'] === 'admin'): ?>
                        <a href="admin/dashboard.php" class="btn btn-sm btn-outline-light">Dashboard</a>
                    <?php elseif ($_SESSION['user_role'] === 'trainer'): ?>
                        <a href="trainer/dashboard.php" class="btn btn-sm btn-outline-light">Dashboard</a>
                    <?php elseif ($_SESSION['user_role'] === 'member'): ?>
                        <a href="member/dashboard.php" class="btn btn-sm btn-outline-light">Dashboard</a>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
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
                        <a class="nav-link" href="index.php#hero">Home</a>
                        <a class="nav-link" href="index.php#features">Features</a>
                        <a class="nav-link" href="index.php#gallery">Gallery</a>
                        <a class="nav-link" href="index.php#pricing">Pricing</a>
                        <a class="nav-link active" aria-current="page" href="classes.php">Classes</a>
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
                            <a class="btn btn-danger text-light px-3 w-100" href="./processes/process_logout.php"
                                role="button">Logout</a>
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


    <!-- main -->
    <main class="container my-10">
        <h1 class="mb-4">All Classes</h1>

        <div class="row">

            <!-- Display Bootstrap Alert -->
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
                <form method="GET" action="classes.php" class="mb-4 w-50 d-flex gap-2">
                    <input type="text" class="form-control bg-dark text-light border-secondary rounded-3" name="search"
                        placeholder="Search by class name"
                        value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                    <button class="btn btn-purple rounded-3" type="submit">Search</button>
                    <a href="classes.php" class="btn btn-outline-secondary rounded-3">Clear</a>
                </form>
            </div>

            <div class="col-lg-12 rounded">
                <div id="" class="row g-4">

                    <?php
                    include "processes/GET/getAvailableSessions.php"; // Include the database connection and query

                    // Check if there are any classes available
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<div class="col-md-4">';
                            echo '<div class="card bg-tertiary bg-gradient text-light">';
                            echo '<div class="card-header bg-dark bg-gradient border-0">';
                            echo '<h5 class="card-title fs-4">' . htmlspecialchars($row['class_name']) . '</h5>';
                            echo '</div>';

                            echo '<div class="card-body">';

                            // Image

                            // If the image URL is empty, use a placeholder image
                            if (empty($row['image_url'])) {
                                echo '<img src="./public/blackwhite.svg" class="card-img-top rounded-2 mb-3" style="height:250px; object-fit:cover" alt="Class Image">';
                            } else {
                                echo '<img src="' . htmlspecialchars($row['image_url']) . '" class="card-img-top rounded-2 mb-3" style="height:250px; object-fit:cover" alt="Class Image">';
                            }

                            echo '<p class="card-text text-secondary">' . htmlspecialchars($row['description']) . '</p>';

                            echo '<p class="card-text"><i class="bi bi-calendar text-secondary"></i> <span class="text-light"></span>';
                            echo '<span class="text-light">' . htmlspecialchars(date("F j, Y", strtotime($row['session_date']))) . '</span>';
                            echo '</p>';
                            echo '<p class="card-text"><i class="bi bi-clock text-secondary"></i> <span class="text-light"></span>';
                            echo '<span class="text-light">' . htmlspecialchars(date("g:i A", strtotime($row['start_time']))) . ' - ' . htmlspecialchars(date("g:i A", strtotime($row['end_time']))) . '</span>';
                            echo '</p>';
                            echo '<p class="card-text"><i class="bi bi-person text-secondary"></i> <span class="text-light"></span>';
                            echo '<span class="text-light">' . htmlspecialchars($row['total_enrolled']) . '/' . htmlspecialchars($row['capacity']) . '</span>';
                            echo '</p>';


                            // Enroll Button

                            // If user is not logged in, clicking the button will redirect to the login page
                            if (!isset($_SESSION['user_id'])) {
                                echo '<a type="button" href="./auth/login.php" class="btn btn-purple text-light">Enroll</a>';
                            } else {
                                echo '<form method="POST" action="./processes/POST/enrollUserSession.php" class="mt-3">';
                                echo '<input type="hidden" name="user_id" value="' . htmlspecialchars($_SESSION['user_id']) . '">';
                                echo '<button type="submit" name="session_id" value="' . htmlspecialchars($row['id']) . '"'
                                    . ' class="btn btn-purple text-light"'
                                    . ' onclick="return confirm(\'Are you sure you want to enroll in ' . htmlspecialchars($row["class_name"]) . '?\');">';
                                echo 'Enroll';
                                echo '</button>';
                                echo '</form>';
                            }



                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                        }
                    } else {
                        echo ' <div class="alert alert-danger alert-dismissible fade show" role="alert"> ';
                        echo ' No classes found.';
                        echo '</div>';
                    }
                    ?>

                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq"
        crossorigin="anonymous"></script>


</body>

</html>