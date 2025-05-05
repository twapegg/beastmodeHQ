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

        <h1 class="mt-5 mb-5">Welcome back, Jose!</h1>

        <div class="row justify-content-between">
            <div class="col-3">
                <div class="card w-200 h-100 shadow-sm bg-primary text-light">
                    <div class="card-body d-flex flex-column p-4">
                        <h4 class="card-title ">Upcoming Classes</h4>
                        <p class="card-text text-secondary mt-4 fs-4">3</p>
                    </div>
                </div>

            </div>

            <div class="col-3">
                <div class="card h-100 shadow-sm bg-primary text-light">
                    <div class="card-body d-flex flex-column p-4">
                        <h4 class="card-title ">Sessions this Month</h4>
                        <p class="card-text text-secondary mt-4 fs-4">12</p>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="card h-100 shadow-sm bg-primary text-light">
                    <div class="card-body d-flex flex-column p-4">
                        <h4 class="card-title">Attendance Rate</h4>
                        <p class="card-text text-secondary mt-4 fs-4">100%</p>
                    </div>
                </div>
            </div>
        </div>

        <h3 class="mt-5">Available Classes</h3>

        <div class="row justify-content-evenly mt-3">

            <div class="col-3">

                <div class="card h-100 bg-primary text-light p-3 pb-2 shadow-sm">

                    <img class="d-block mx-auto rounded card-img-top" src="../images/workout.jpg" width="280px"
                        height="150px" alt="black man working out">
                    <h5 class="text-white fw-semibold text-start mt-2">Calisthenics Training</h5>
                    <p class="fw-light text-secondary">Mon, April 29, 2025 - 10:00 AM</p>

                    <div class="card-footer d-flex justify-content-between p-0">
                        <p class="text-white fw-lighter fs-6">
                            <i class="bi bi-person-fill"></i> 5/10
                        </p>
                        <button type="submit" class=" col-4 btn btn-secondary">Enroll</button>
                    </div>
                </div>

            </div>

            <div class="col-3">

                <div class="card h-100 bg-primary text-light p-3 pb-2 shadow-sm">

                    <img class="d-block mx-auto rounded card-img-top" src="../images/workout.jpg" width="280px"
                        height="150px" alt="black man working out">
                    <h5 class="text-white fw-semibold text-start mt-2">Calisthenics Training</h5>
                    <p class="fw-light text-secondary">Mon, April 29, 2025 - 10:00 AM</p>

                    <div class="card-footer d-flex justify-content-between p-0">
                        <p class="text-white fw-lighter fs-6">
                            <i class="bi bi-person-fill"></i> 5/10
                        </p>
                        <button type="submit" class=" col-4 btn btn-secondary">Enroll</button>
                    </div>
                </div>

            </div>

            <div class="col-3">

                <div class="card h-100 bg-primary text-light p-3 pb-2 shadow-sm">

                    <img class="d-block mx-auto rounded card-img-top" src="../images/workout.jpg" width="280px"
                        height="150px" alt="black man working out">
                    <h5 class="text-white fw-semibold text-start mt-2">Calisthenics Training</h5>
                    <p class="fw-light text-secondary">Mon, April 29, 2025 - 10:00 AM</p>

                    <div class="card-footer d-flex justify-content-between p-0">
                        <p class="text-white fw-lighter fs-6">
                            <i class="bi bi-person-fill"></i> 5/10
                        </p>
                        <button type="submit" class=" col-4 btn btn-secondary">Enroll</button>
                    </div>
                </div>

            </div>

            <div class="col-3">

                <div class="card h-100 bg-primary text-light p-3 pb-2 shadow-sm">

                    <img class="d-block mx-auto rounded card-img-top" src="../images/workout.jpg" width="280px"
                        height="150px" alt="black man working out">
                    <h5 class="text-white fw-semibold text-start mt-2">Calisthenics Training</h5>
                    <p class="fw-light text-secondary">Mon, April 29, 2025 - 10:00 AM</p>

                    <div class="card-footer d-flex justify-content-between p-0">
                        <p class="text-white fw-lighter fs-6">
                            <i class="bi bi-person-fill"></i> 5/10
                        </p>
                        <button type="submit" class=" col-4 btn btn-secondary">Enroll</button>
                    </div>
                </div>

            </div>

    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq"
        crossorigin="anonymous"></script>
</body>

</html>