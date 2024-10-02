<?php require_once("database/config.php");

if (isset($_SESSION['login_sess'])) {
    if ($_SESSION['login_sess'] == "1") {
        $_SESSION['email'] = $email;
        header('Location:home_page.php');
    } else {
        echo "0";
    }
} 

// Handle the form submission
if (isset($_POST['signup'])) {
    extract($_POST);

    // Validation logic
    if (strlen($email) > 50) {
        $error[] = 'Email: max length is 50 characters';
    }

    if ($passwordConfirm == '') {
        $error[] = 'Please confirm the password';
    }

    if ($password != $passwordConfirm) {
        $error[] = 'Passwords do not match';
    }

    if (strlen($password) < 6) {
        $error[] = 'Password should be at least 6 characters long';
    }

    if (strlen($password) > 20) {
        $error[] = 'Password: Max length 20 characters not allowed';
    }

    // Check if email already exists in the database
    $sql = "SELECT * FROM users WHERE email='$email'";
    $res = mysqli_query($dbc, $sql);

    if (mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_assoc($res);
        if ($email == $row['email']) {
            $error[] = 'Email already exists';
        }
    }

    // If no errors, proceed with registration
    if (!isset($error)) {
        $options = array("cost" => 4);
        $password = password_hash($password, PASSWORD_BCRYPT, $options);
        $result = mysqli_query($dbc, "INSERT INTO users VALUES('', '$name', '$email', '$password')");

        if ($result) {
            $done = 2;
        } else {
            $error[] = 'Failed: Something went wrong';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
       
    <meta charset="UTF-8">
       
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
       
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Signup Page</title>
        <!-- Bootstrap CSS -->
       
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
        <div class="container mt-5">
                

               
        <?php if (isset($error)): ?>
                    <div class="col">
                           
            <?php foreach ($error as $error): ?>
                                <div class="alert alert-danger" role="alert">&#x26A0;
                <?php echo $error; ?>
            </div>
                           
            <?php endforeach; ?>
                       
        </div>
               
        <?php endif; ?>

               
        <?php if (isset($done)): ?>
                   
        <?php header("location:login.php"); ?>
               
        <?php else: ?>
                    <h2 class="mb-4 text-center ">Sign-up</h2>
                    <form method="post" class="row g-3">
                            <!-- Name Input -->
                            <div class="col-md-6">
                                    <label for="name" class="form-label">Name*</label>
                                    <input type="text" name="name" class="form-control" placeholder="Enter Your Name"
                    value="<?php if (isset($error)) echo $name; ?>" required>
                                </div>

                            <!-- Email Input -->
                            <div class="col-md-6">
                                    <label for="email" class="form-label">Email*</label>
                                    <input type="email" name="email" class="form-control"
                    placeholder="Enter Your Email Address" value="<?php if (isset($error)) echo $email; ?>" required>
                                </div>

                            <!-- Password Input -->
                            <div class="col-md-6">
                                    <label for="password" class="form-label">Password*</label>
                                    <input type="password" name="password" id="password" class="form-control"
                    placeholder="Enter Your Password" required>
                                    <div class="form-check mt-2">
                                            <input class="form-check-input" type="checkbox" id="showPassword">
                                            <label class="form-check-label" for="showPassword">Show password</label>
                                        </div>
                                </div>

                            <!-- Confirm Password Input -->
                            <div class="col-md-6">
                                    <label for="passwordConfirm" class="form-label">Confirm Password*</label>
                                    <input type="password" name="passwordConfirm" id="passwordConfirm"
                    class="form-control" placeholder="Confirm Your Password" required>
                                    <div class="form-check mt-2">
                                            <input class="form-check-input" type="checkbox" id="showPasswordConfirm">
                                            <label class="form-check-label" for="showPasswordConfirm">Show
                        password</label>
                                        </div>
                                </div>

                            <!-- Sign-up Button -->
                            <div class="col-12">
                                    <button type="submit" name="signup" class="btn btn-primary">Sign-up</button>
                                </div>

                            <!-- Login Link -->
                            <div class="col-12">
                                    <p>Have an Account? <a href="login.php">Login</a></p>
                                </div>
                        </form>
               
        <?php endif; ?>
           
    </div>

        <!-- Bootstrap JS and JS for password visibility toggle -->
       
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        const passwordInput = document.getElementById('password');
        const passwordConfirmInput = document.getElementById('passwordConfirm');
        const showPasswordCheckbox = document.getElementById('showPassword');
        const showPasswordConfirmCheckbox = document.getElementById('showPasswordConfirm');

        showPasswordCheckbox.addEventListener('change', function () {
            passwordInput.type = showPasswordCheckbox.checked ? 'text' : 'password';
        });

        showPasswordConfirmCheckbox.addEventListener('change', function () {
            passwordConfirmInput.type = showPasswordConfirmCheckbox.checked ? 'text' : 'password';
        });
    </script>
</body>

</html>