<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="stylesheet" href="../styles.css">
    <link rel="shortcut icon" href="../public/favicon.ico" type="image/x-icon">
    <title>Sign Up - BeastModeHQ</title>
</head>

<body class="d-flex container flex-column mt-8 align-items-center vw-100 vh-100">
    <div class="d-flex justify-content-center mb-4">
        <a href="../index.php" class="text-decoration-none">
            <img src="../public/blackwhite.svg" alt="BeastModeHQ Logo" class="img-fluid rounded-circle" width="100"
                height="100">
        </a>
    </div>
    <h1 class="display-7 mb-5">Create your account</h1>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="">
                    <form action="../processes/process_signup.php" method="POST"
                        class="d-flex flex-column justify-content-center gap-3">
                        <div class="">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" class="form-control bg-tertiary border-dark-subtle text-light" id="name"
                                name="name" required>
                        </div>
                        <div class="">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" class="form-control bg-tertiary border-dark-subtle text-light"
                                id="email" name="email" required>
                        </div>
                        <div class="">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control bg-tertiary border-dark-subtle text-light"
                                id="password" name="password" required>
                        </div>
                        <div class="">
                            <label for="date_of_birth" class="form-label">Date of Birth</label>
                            <input type="date" class="form-control bg-tertiary border-dark-subtle text-light"
                                id="date_of_birth" name="date_of_birth">
                        </div>

                        <button type="submit" class="btn btn-brand text-light w-100 mt-3"><strong>Sign
                                Up</strong></button>
                        <div class="card-footer text-center ">
                            <p>Already have an account? <a href="login.php" class="text-brand">Login</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
        <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
            <div id="signupToast" class="toast align-items-center text-bg-success border-0 show" role="alert"
                aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        Signed up successfully! Redirecting to login...
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                        aria-label="Close"></button>
                </div>
            </div>
        </div>

        <script>
            // Automatically hide the toast after 3 seconds
            setTimeout(() => {
                const toast = document.getElementById('signupToast');
                if (toast) {
                    toast.classList.remove('show');
                }
            }, 3000);

            // Redirect to login page after 3 seconds
            setTimeout(() => {
                window.location.href = "login.php";
            }, 3000);
        </script>
    <?php endif; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq"
        crossorigin="anonymous"></script>
</body>

</html>