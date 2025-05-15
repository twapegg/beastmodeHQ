<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'member') {
    header("Location: ../auth/login.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "beastmodehq";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="stylesheet" href="../styles.css">
    <title>BeastModeHQ</title>
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg bg-primary bg-opacity-25 px-4 py-3" data-bs-theme="dark">
        <div class="container-fluid">
            <!-- Logo and Brand Name -->
            <a class="navbar-brand d-flex align-items-center w-25" href="#">
                <img src="./public/blackwhite.svg" alt="Logo" width="50" height="50" class="me-3  rounded-circle">
                <!-- Replace with your logo path -->
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
                <div class="d-flex justify-content-lg-center justify-content-start w-100 ms-0 ms-lg-5 ms-xl-10 ">
                    <div class="navbar-nav">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                        <a class="nav-link" href="#">Features</a>
                        <a class="nav-link" href="#">Gallery</a>
                        <a class="nav-link" href="#">Pricing</a>
                        <a class="nav-link" href="#">Classes</a>
                    </div>
                </div>
                <!-- Login and Sign Up Buttons -->
                <div class="row w-100 d-flex justify-c</body>ontent-center justify-content-lg-end align-items-center gap-3 gap-lg-0">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <div class="col-12 col-lg-auto">
                            <span class="text-light">
                                <strong><?php echo htmlspecialchars(ucwords(strtolower($_SESSION['user_name']))); ?></strong>
                        </div>
                        <div class="col-12 col-lg-auto">
                            <a class="btn btn-danger text-light px-3 w-100" href="./processes/process_logout.php" role="button">Logout</a>
                        </div>
                    <?php else: ?>
                        <div class="col-12 col-lg-auto">
                            <a class="btn btn-tertiary text-light px-3 w-100" href="auth/login.php" role="button">Login</a>
                        </div>
                 </div>       <div class="col-12 col-lg-auto">
                            <a class="btn btn-brand text-light px-3 w-100" href="auth/signup.php" type="button">Get
                                Sta</select>rted</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>




    <!-- main -->
    <main class="container mt-5">

        <h1 class="mt-5 mb-5">Welcome back, Jose!</h1>

        <div class="container bg-dark rounded p-3 shadow-lg">
            <div class="row justify-content-evenly">

            <?php
                // Fetch upcoming classes within 3 days
                $upcomingClassesSql = "
                    SELECT COUNT(*) AS upcoming_count
                    FROM class_sessions cs
                    JOIN class_enrollments ce ON cs.id = ce.class_session_id
                    WHERE ce.user_id = ? AND cs.session_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 3 DAY)";

                $stmt = $conn->prepare($upcomingClassesSql);
                $stmt->bind_param("i", $_SESSION['user_id']);
                $stmt->execute();
                $stmt->bind_result($upcomingCount);
                $stmt->fetch();
                $stmt->close();

                // Fetch sessions this month
                $sessionsThisMonthSql = "
                    SELECT COUNT(*) AS monthly_count
                    FROM class_sessions cs
                    JOIN class_enrollments ce ON cs.id = ce.class_session_id
                    WHERE ce.user_id = ? AND MONTH(cs.session_date) = MONTH(CURDATE()) AND YEAR(cs.session_date) = YEAR(CURDATE())";
                    
                $stmt = $conn->prepare($sessionsThisMonthSql);
                $stmt->bind_param("i", $_SESSION['user_id']);
                $stmt->execute();
                $stmt->bind_result($monthlyCount);
                $stmt->fetch();
                $stmt->close();
            ?>

            <div class="col-4">
                <div class="row justify-content-center">
                    <div class="card col-3 bg-white white rounded-0 rounded-start">
                        <i class="bi bi-calendar-event text-secondary-emphasis display-3 mt-4 ms-2"></i>
                    </div>
                    <div class="card col-8 h-100 rounded-0 rounded-end bg-primary text-light">
                        <div class="card-body d-flex flex-column p-4">
                            <h5 class="card-title">Upcoming Classes</h5>
                            <p class="card-text text-secondary mt-4 fs-3"><?php echo $upcomingCount; ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-4">
                <div class="row justify-content-center">
                    <div class="card col-3 bg-white white rounded-0 rounded-start">
                        <i class="bi bi-calendar3 text-secondary-emphasis display-3 mt-4 ms-2"></i>
                    </div>
                    <div class="card col-8 h-100 rounded-0 rounded-end bg-primary text-light">
                        <div class="card-body d-flex flex-column p-4">
                            <h5 class="card-title">Sessions this Month</h5>
                            <p class="card-text text-secondary mt-4 fs-3"><?php echo $monthlyCount; ?></p>
                        </div>
                    </div>
                </div>
            </div>

                <div class="col-4">
                    <div class="row justify-content-center">
                    <div class="card col-3  bg-white white rounded-0 rounded-start">
                        <i class="bi bi-graph-up text-secondary-emphasis display-3 mt-4 ms-2"></i>
                    </div>     
                    <div class="card col-8 h-100 rounded-0 rounded-end bg-primary text-light">
                        <div class="card-body d-flex flex-column p-4">
                            <h5 class="card-title ">Attendance Rate</h5>
                            <p class="card-text text-secondary mt-4 fs-3">100%</p>
                        </div>
                    </div>
                    </div>

                </div>

            </div>
        </div>

        <h3 class="mt-5">Available Classes</h3>

        <div class="container bg-dark rounded p-3 shadow-sm">
            <div class="row mb-4">
                <form class="d-flex" method="GET" action="">

                    <input class="form-control me-2" type="search" name="search" placeholder="Search classes..." aria-label="Search" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                    <button class="btn btn-secondary me-2" type="submit">Search</button>

                    <select class="form-select w-auto me-2" name="sort" onchange="this.form.submit()">
                        <option value="" disabled selected>Sort by</option>
                        <option value="asc" <?php echo (isset($_GET['sort']) && $_GET['sort'] === 'asc') ? 'selected' : ''; ?>>Date Ascending</option>
                        <option value="desc" <?php echo (isset($_GET['sort']) && $_GET['sort'] === 'desc') ? 'selected' : ''; ?>>Date Descending</option>
                    </select>

                </form>

                <?php

                    $searchCondition = '';
                    
                    if (isset($_GET['search']) && !empty(trim($_GET['search']))) {
                        $searchTerm = $conn->real_escape_string(trim($_GET['search']));
                        $searchCondition = "WHERE c.name LIKE '%$searchTerm%'";
                    }

                    $sortOrder = 'DESC'; // Default sort order
                    if (isset($_GET['sort']) && in_array($_GET['sort'], ['asc', 'desc'])) {
                        $sortOrder = strtoupper($_GET['sort']);
                    }

                    $availabilityCondition = '';

                    if (isset($_GET['availability']) && $_GET['availability'] !== 'all') {
                        if ($_GET['availability'] === 'available') {
                            $availabilityCondition = "HAVING enrolled_count < cs.capacity";
                        } elseif ($_GET['availability'] === 'full') {
                            $availabilityCondition = "HAVING enrolled_count >= cs.capacity";
                        }
                    }

                    $sql = "
                            SELECT 
                            cs.id AS session_id,
                            c.name AS class_name,
                            c.description AS class_description,
                            cs.session_date,
                            cs.start_time,
                            cs.end_time,
                            cs.capacity,
                            COUNT(ce.id) AS enrolled_count

                            FROM class_sessions cs
                            JOIN classes c ON cs.class_id = c.id
                            LEFT JOIN class_enrollments ce ON cs.id = ce.class_session_id
                            $searchCondition
                            GROUP BY cs.id, c.name, c.description, cs.session_date, cs.start_time, cs.end_time, cs.capacity
                            $availabilityCondition
                            ORDER BY cs.session_date $sortOrder, cs.start_time $sortOrder";

                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {

                        echo '<div class="row justify-content-evenly mt-2 g-4">';

                        while ($row = $result->fetch_assoc()) {
                            if ($row['enrolled_count'] < $row['capacity']) { 

                                echo '<div class="col-3">';
                                echo '<div class="card h-100 bg-primary text-light p-3 pb-2 shadow-sm">';
                                echo '<img src="../images/' . htmlspecialchars($row['class_name']) . '.png" class="card-img-top rounded" alt="' . htmlspecialchars($row['class_name']) . '">';
                                echo '<h5 class="text-white fw-semibold text-start mt-2">' . htmlspecialchars($row['class_name']) . '</h5>';
                                echo '<p class="fw-light text-secondary">' . htmlspecialchars(date("D, M j, Y - g:i A", strtotime($row['session_date'] . ' ' . $row['start_time']))) . '</p>';
                                echo '<p class="text-light">' . htmlspecialchars($row['class_description']) . '</p>';
                                echo '<div class="card-footer d-flex justify-content-between p-0">';

                                echo '<p class="text-white fw-lighter fs-6"><i class="bi bi-person-fill"></i> ' . htmlspecialchars($row['enrolled_count']) . '/' . htmlspecialchars($row['capacity']) . '</p>';
                                echo '<button type="submit" class="col-4 btn btn-secondary">Enroll</button>';
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                            }
                        }

                        echo '</div>';
                    } else {
                        echo '<p class="text-light">No classes match your search.</p>';
                    }
                
                ?>

            </div>
            
        </div>

    </div>

    </mai>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq"
        crossorigin="anonymous"></script>
</body>

</html>