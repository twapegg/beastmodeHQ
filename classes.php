<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
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

    <h1 class="mt-5">All Classes</h1>

    <div class="container bg-dark p-4 rounded shadow-sm">
    <div class="row mb-4">
        <div class="col-md-6">
            <form class="d-flex align-items-center">
                <input class="form-control me-2 text-white" type="search" placeholder="Search classes..." aria-label="Search">
                <button class="btn btn-secondary" type="submit">Search</button>
            </form>
        </div>
        <div class="col-md-6">
            <div class="d-flex justify-content-md-end justify-content-start mt-3 mt-md-0">
                <select class="form-select w-auto me-2 text-light" aria-label="Filter by category">
                    <option selected>Filter by Category</option>
                    <option value="1">Strength</option>
                    <option value="2">Cardio</option>
                    <option value="3">Flexibility</option>
                </select>
                <select class="form-select w-auto text-light" aria-label="Sort by date">
                    <option selected>Sort by Date</option>
                    <option value="1">Upcoming</option>
                    <option value="2">Past</option>
                </select>
            </div>
        </div>
    </div>
        <div class="row justify-content-evenly mt-2">

            <div class="col-3">

                <div class="card h-100 bg-primary text-light p-3 pb-2 shadow-sm">

                    <img class="d-block mx-auto rounded card-img-top" src="images/workout.jpg" width="280px"
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

                    <img class="d-block mx-auto rounded card-img-top" src="images/workout.jpg" width="280px"
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

                    <img class="d-block mx-auto rounded card-img-top" src="images/workout.jpg" width="280px"
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

                    <img class="d-block mx-auto rounded card-img-top" src="images/workout.jpg" width="280px"
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
        </div>
    </div
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq"
        crossorigin="anonymous"></script>
</body>

</html>