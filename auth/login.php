<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="stylesheet" href="../styles.css">
    <title>Login - BeastModeHQ</title>
</head>

<body class="d-flex container flex-column mt-10 align-items-center vw-100 vh-100">
    <div class="d-flex justify-content-center mb-4">
        <a href="../index.php" class="text-decoration-none">
            <img src="../public/blackwhite.svg" alt="BeastModeHQ Logo" class="img-fluid rounded-circle" width="100"
                height="100">
        </a>
    </div>
    <h1 class="display-7 mb-5">Welcome back</h1>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="">
                    <form action="../processes/process_login.php" method="POST"
                        class="d-flex flex-column justify-content-center gap-3">
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
                        <button type="submit"
                            class="btn btn-brand text-light w-100 mt-3"><strong>Login</strong></button>
                        <div class="card-footer text-center">
                            <p>Don't have an account? <a href="signup.php" class="text-brand">Sign up</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Notifications -->
    <?php if (isset($_GET['error'])): ?>
        <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
            <div class="toast align-items-center text-bg-danger border-0 show" role="alert" aria-live="assertive"
                aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        <?php
                        if ($_GET['error'] == 'empty_fields') {
                            echo "Please fill in all fields.";
                        } elseif ($_GET['error'] == 'invalid_password') {
                            echo "Invalid password. Please try again.";
                        } elseif ($_GET['error'] == 'no_account') {
                            echo "No account found with that email.";
                        }
                        ?>
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                        aria-label="Close"></button>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq"
        crossorigin="anonymous"></script>
</body>

</html>