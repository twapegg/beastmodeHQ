<?php
session_start();

// Check if the user is logged in and their role is admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit();
}

// Include the backend logic to fetch classes
include "../processes/GET/getAllClasses.php";
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
    <title>Manage Classes</title>
</head>

<body class="text-light">

    <!-- Navigation -->
    <nav class="navbar fixed-top navbar-expand-lg bg-dark px-4 py-3" data-bs-theme="dark">
        <div class="container-fluid">
            <!-- Logo and Brand Name -->
            <a class="navbar-brand d-flex align-items-center w-25" href="#">
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
                        <a class="nav-link" href="./memberships.php">Manage Memberships</a>
                        <a class="nav-link active" aria-current="page" href="./classes.php">Manage Classes</a>
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
                            <a class="btn btn-danger text-light px-3 w-100" href="../processes/process_logout.php"
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

    <main class="container mt-10">
        <h1 class="mb-4">Manage Classes</h1>

        <!-- Success/Error Messages -->
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
                <button class="btn btn-light rounded-3" type="submit">Search</button>
                <a href="classes.php" class="btn btn-secondary rounded-3">Clear</a>
            </form>
            <!-- Button to trigger modal -->
            <button type="button" class="btn btn-brand mb-4 text-light" data-bs-toggle="modal"
                data-bs-target="#addClassModal">
                Add New Class
            </button>
        </div>

        <!-- Add Class Modal -->
        <div class="modal fade" id="addClassModal" tabindex="-1" aria-labelledby="addClassModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content bg-dark text-light">
                    <div class="modal-header bg-primary text-light">
                        <h5 class="modal-title text-light" id="addClassModalLabel">Add New Class</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="../processes/POST/addClass.php" method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="className" class="form-label">Class Name</label>
                                <input type="text" class="form-control bg-dark text-light border-secondary"
                                    id="className" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="classDescription" class="form-label">Description</label>
                                <textarea class="form-control bg-dark text-light border-secondary" id="classDescription"
                                    name="description" rows="3"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="classImage" class="form-label">Class Image</label>
                                <input type="file" class="form-control bg-dark text-light border-secondary"
                                    id="classImage" name="image" accept="image/*" required>
                            </div>
                            <div class="modal-footer border-secondary">
                                <button type="button" class="btn btn-secondary text-light"
                                    data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success text-light">Add Class</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Classes Table -->
        <div class="card bg-dark text-light">
            <div class="card-header bg-secondary text-white">
                <h5>Classes</h5>
            </div>
            <div class="card-body">
                <table class="table table-dark table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Class Name</th>
                            <th>Description</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($classes)): ?>
                            <?php foreach ($classes as $class): ?>
                                <tr>
                                    <td><?php echo $class['id']; ?></td>
                                    <td><?php echo htmlspecialchars($class['name']); ?></td>
                                    <td><?php echo htmlspecialchars($class['description']); ?></td>
                                    <td><?php echo htmlspecialchars($class['created_at']); ?></td>
                                    <td><?php echo htmlspecialchars($class['updated_at']); ?></td>
                                    <td>
                                        <div class="d-flex gap-2" role="group">
                                            <!-- Edit Button -->
                                            <button class="btn btn-sm btn-light" data-bs-toggle="modal"
                                                data-bs-target="#editClassModal-<?php echo $class['id']; ?>">Edit</button>
                                            <!-- Delete Button -->
                                            <form action="../processes/POST/deleteClass.php" method="POST" class="d-inline"
                                                onsubmit="return confirm('Are you sure you want to delete this class?');">
                                                <input type="hidden" name="class_id" value="<?php echo $class['id']; ?>">
                                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Edit Class Modal -->
                                <div class="modal fade" id="editClassModal-<?php echo $class['id']; ?>" tabindex="-1"
                                    aria-labelledby="editClassModalLabel-<?php echo $class['id']; ?>" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content bg-dark text-light">
                                            <div class="modal-header bg-primary text-light">
                                                <h5 class="modal-title" id="editClassModalLabel-<?php echo $class['id']; ?>">
                                                    Edit Class</h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="../processes/POST/editClass.php" method="POST"
                                                    enctype="multipart/form-data">
                                                    <input type="hidden" name="class_id" value="<?php echo $class['id']; ?>">
                                                    <div class="mb-3">
                                                        <label for="editClassName-<?php echo $class['id']; ?>"
                                                            class="form-label">Class Name</label>
                                                        <input type="text"
                                                            class="form-control bg-dark text-light border-secondary"
                                                            id="editClassName-<?php echo $class['id']; ?>" name="name"
                                                            value="<?php echo htmlspecialchars($class['name']); ?>" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="editClassDescription-<?php echo $class['id']; ?>"
                                                            class="form-label">Description</label>
                                                        <textarea class="form-control bg-dark text-light border-secondary"
                                                            id="editClassDescription-<?php echo $class['id']; ?>"
                                                            name="description"
                                                            rows="3"><?php echo htmlspecialchars($class['description']); ?></textarea>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="editClassImage-<?php echo $class['id']; ?>"
                                                            class="form-label">Class Image</label>
                                                        <input type="file"
                                                            class="form-control bg-dark text-light border-secondary"
                                                            id="editClassImage-<?php echo $class['id']; ?>" name="image"
                                                            accept="image/*">
                                                        <small class="text-secondary">Leave blank to keep the current
                                                            image.</small>
                                                    </div>
                                                    <div class="modal-footer border-secondary">
                                                        <button type="button" class="btn btn-secondary text-light"
                                                            data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-success text-light">Save
                                                            Changes</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center">No classes found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq"
        crossorigin="anonymous"></script>
</body>

</html>