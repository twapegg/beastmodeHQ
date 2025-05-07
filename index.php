<?php
session_start(); // Start the session
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
    <title>BeastModeHQ</title>
</head>

<body>

    <!-- Navigation -->
    <!-- Navigation -->
    <nav class="navbar fixed-top navbar-expand-lg bg-primary bg-opacity-25 px-4 py-3" data-bs-theme="dark">
        <div class="container-fluid">
            <!-- Logo and Brand Name -->
            <a class="navbar-brand d-flex align-items-center w-25" href="#">
                <img src="./public/blackwhite.svg" alt="Logo" width="50" height="50" class="me-3 rounded-circle">
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
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                        <a class="nav-link" href="#">Features</a>
                        <a class="nav-link" href="#">Gallery</a>
                        <a class="nav-link" href="#">Pricing</a>
                        <a class="nav-link" href="#">Classes</a>
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
                            <a class="btn btn-danger text-light px-3 w-100" href="./processes/process_logout.php" role="button">Logout</a>
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
    <main class="mt-5">
        <section class="hero section">
            <div class="container">
                <div class="row">
                    <div class="mt-15 col-md-8 offset-md-2 text-center">
                        <h1 class="display-2"><strong>Unleash the Beast Within</strong></h1>
                        <p class="text-secondary mt-3 display-6">Train harder. Get stronger. No excuses.
                            This isn’t your average gym — this is your headquarters for domination.</p>
                        <!-- CTA Buttons -->
                        <div class="mt-5 d-flex justify-content-center gap-4">
                            <a href="./auth/signup.php" class="btn btn-light text-primary btn-lg"><strong>Join the
                                    Pack</strong></a>
                            <a href="./classes.php" class="btn btn-outline-light btn-lg">Explore Programs</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="carousel-section section container mt-10">
            <h1 class="text-center mb-5">Our Facilities ⚡</h1>
            <div id="carouselExample" class="carousel slide custom-carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="https://southsidegym.ie/wp-content/uploads/2023/04/P1255237-900x1200.jpg"
                            class="d-block w-100" alt="...">
                    </div>
                    <div class="carousel-item">
                        <img src="https://southsidegym.ie/wp-content/uploads/2023/04/P1255289-900x1200.jpg"
                            class="d-block w-100" alt="...">
                    </div>
                    <div class="carousel-item">
                        <img src="https://southsidegym.ie/wp-content/uploads/2023/04/P1255246-900x1200.jpg"
                            class="d-block w-100" alt="...">
                    </div>
                    <div class="carousel-item">
                        <img src="https://southsidegym.ie/wp-content/uploads/2023/04/P1255243-900x1200.jpg"
                            class="d-block w-100" alt="...">
                    </div>
                    <div class="carousel-item">
                        <img src="https://southsidegym.ie/wp-content/uploads/2023/04/P1255297-900x1200.jpg"
                            class="d-block w-100" alt="...">
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExample"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </section>
        <section class="features section container mt-10">
            <h1 class="text-center mb-5 text-light">Get the Full Gym Experience</h1>
            <div class="row text-center">
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm bg-dark text-light">
                        <div class="card-body d-flex flex-column p-4">
                            <i class="bi bi-tools text-info display-4 mb-2"></i>
                            <h5 class="card-title mt-3">State of the Art Equipment</h5>
                            <p class="card-text text-secondary">Experience the latest in fitness technology to maximize
                                your workouts.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm bg-dark text-light">
                        <div class="card-body d-flex flex-column p-4">
                            <i class="bi bi-calendar-event-fill text-success display-4 mb-2"></i>
                            <h5 class="card-title mt-3">Fitness Classes</h5>
                            <p class="card-text text-secondary">Join a variety of classes led by expert instructors to
                                suit all fitness levels.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm bg-dark text-light">
                        <div class="card-body d-flex flex-column p-4">
                            <i class="bi bi-droplet-fill text-info display-4 mb-2"></i>
                            <h5 class="card-title mt-3">On-Site Spa</h5>
                            <p class="card-text text-secondary">Relax and rejuvenate with our luxurious spa services
                                after your workout.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm bg-dark text-light">
                        <div class="card-body d-flex flex-column p-4">
                            <i class="bi bi-person-lines-fill text-warning display-4 mb-2"></i>
                            <h5 class="card-title mt-3">Nutrition Counseling</h5>
                            <p class="card-text text-secondary">Get personalized advice and plans from our certified
                                fitness counselors.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm bg-dark text-light">
                        <div class="card-body d-flex flex-column p-4">
                            <i class="bi bi-people-fill text-success display-4 mb-2"></i>
                            <h5 class="card-title text-light mt-3">Community Support</h5>
                            <p class="card-text text-secondary">Join a community of like-minded individuals who motivate
                                and inspire.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm bg-dark text-light">
                        <div class="card-body d-flex flex-column p-4">
                            <i class="bi bi-award-fill text-warning display-4 mb-2"></i>
                            <h5 class="card-title text-light mt-3">Certified Trainers</h5>
                            <p class="card-text text-secondary">Train with the best in the industry to achieve your
                                fitness goals.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <script src=" https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous">
    </script>
</body>

</html>