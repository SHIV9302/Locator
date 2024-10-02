<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <?php
                // Handle error messages
                if (isset($_GET['error'])) {
                    $error = $_GET['error'];
                    if ($error == "invalid_password") {
                        echo '<div class="alert alert-danger text-center">Invalid password. Please try again.</div>';
                    } elseif ($error == "invalid_credentials") {
                        echo '<div class="alert alert-danger text-center">Invalid credentials. Please try again.</div>';
                    }
                }
                ?>

                <div class="card shadow-sm">
                    <div class="card-body">
                        <h2 class="card-title text-center mb-4">Login</h2>

                        <form action="login_process.php" method="POST">
                            <!-- Email Input -->
                            <div class="mb-3">
                                <label for="login_var" class="form-label">Email</label>
                                <input type="email" name="login_var" id="login_var" class="form-control" placeholder="Enter Your Email" required>
                            </div>

                            <!-- Password Input -->
                            <div class="mb-3">
                                <label for="user_password" class="form-label">Password</label>
                                <div class="input-group">
                                    <input type="password" name="password" id="user_password" class="form-control" placeholder="Enter Your Password" required>
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword()">Show</button>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="d-grid gap-2">
                                <button type="submit" name="sublogin" class="btn btn-primary btn-block">Login</button>
                            </div>

                            <!-- Forgot Password Link -->
                            <div class="mt-3 text-center">
                                <a href="forgot-password.php">Forgot Password?</a>
                            </div>

                            <!-- Sign-up Link -->
                            <div class="mt-3 text-center">
                                <p>Don't have an account? <a href="signup.php">Sign-up</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and Dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Password Toggle JS -->
    <script>
        function togglePassword() {
            var passwordInput = document.getElementById("user_password");
            passwordInput.type = passwordInput.type === "password" ? "text" : "password";
        }
    </script>
</body>
</html>
