<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="stylesheet" href="../styles.css">
    <title>BeastModeHQ</title>
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg bg-primary bg-opacity-25 px-4 py-3 rounded" data-bs-theme="dark">
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
                <div
                    class="row w-100 d-flex justify-content-center justify-content-lg-end align-items-center gap-3 gap-lg-0">
                    <div class="col-12 col-lg-auto">
                        <a class="btn btn-tertiary text-light px-3 w-100" href="auth/login.php" role="button">Login</a>
                    </div>
                    <div class="col-12 col-lg-auto">
                        <a class="btn btn-brand text-light px-3 w-100" href="auth/signup.php" type="button">Get
                            Started</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- main -->
    <main class="container mt-5">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3">
            <nav class="nav flex-column bg-primary p-3 h-100" style="height: 100vh;">
                <a class="nav-link active text-light" href="#">Dashboard</a>
                <a class="nav-link text-light" href="#">Profile</a>
                <a class="nav-link text-light" href="#">Settings</a>
                <a class="nav-link text-light" href="#">Logout</a>
            </nav>
            </div>

            <!-- Main Content -->
            <div class="col-md-9">
            <div class="row g-3">
                <!-- Top Row: 1x2 -->
                <div class="col-md-6">
                <div class="card bg-primary text-light">
                    <div class="card-body">
                    <h5 class="card-title">Card 1</h5>
                    <p class="card-text">Content for card 1.</p>
                    </div>
                </div>
                </div>
                <div class="col-md-6">
                <div class="card bg-primary text-light">
                    <div class="card-body">
                    <h5 class="card-title">Card 2</h5>
                    <p class="card-text">Content for card 2.</p>
                    </div>
                </div>
                </div>

                <!-- Middle Row: Card 3 -->
                <div class="col-md-12">
                <div class="card bg-primary text-light">
                    <div class="card-body">
                    <h5 class="card-title">Card 3</h5>
                    <div class="row g-3">
                        <div class="col-md-12">
                        <div class="card bg-primary text-light">
                            <div class="card-body">
                            <h6 class="card-title">Subcard 3.1</h6>
                            <p class="card-text">Content for subcard 3.1.</p>
                            </div>
                        </div>
                        </div>
                        <div class="col-md-12">
                        <div class="card bg-primary text-light">
                            <div class="card-body">
                            <h6 class="card-title">Subcard 3.2</h6>
                            <p class="card-text">Content for subcard 3.2.</p>
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>
                </div>
                </div>

                <!-- Bottom Row: Card 4 -->
                <div class="col-md-12">
                <div class="card bg-primary text-light">
                    <div class="card-body">
                    <h5 class="card-title">Card 4</h5>
                    <div class="row g-3">
                        <div class="col-md-12">
                        <div class="card bg-primary text-light">
                            <div class="card-body">
                            <h6 class="card-title">Subcard 4.1</h6>
                            <p class="card-text">Content for subcard 4.1.</p>
                            </div>
                        </div>
                        </div>
                        <div class="col-md-12">
                        <div class="card bg-primary text-light">
                            <div class="card-body">
                            <h6 class="card-title">Subcard 4.2</h6>
                            <p class="card-text">Content for subcard 4.2.</p>
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>
                </div>
                </div>
            </div>
            </div>
        </div>

    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq"
        crossorigin="anonymous"></script>
</body>

</html>