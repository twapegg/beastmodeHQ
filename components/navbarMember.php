<!-- Navigation -->
<nav class="navbar fixed-top navbar-expand-lg bg-primary px-4 py-3" data-bs-theme="dark">
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