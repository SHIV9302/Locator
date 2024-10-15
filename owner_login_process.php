<?php 
// Include the database configuration file
require_once("database/config.php");

// Start session
session_start();

// Check if the login form was submitted
if (isset($_POST['owner_login'])) {
    // Sanitize the email input to prevent SQL injection
    $login = mysqli_real_escape_string($dbc, $_POST['owner_email']);
    $password = $_POST['owner_password'];

    // Query to check if the owner exists in the 'owners' table
    $query = "SELECT * FROM owners WHERE email = '$login'";
    $res = mysqli_query($dbc, $query);
    
    // Check if the query was successful
    if (!$res) {
        die("Query failed: " . mysqli_error($dbc));
    }

    // Check if the owner exists
    if (mysqli_num_rows($res) == 1) {
        // Fetch the owner's details
        $row = mysqli_fetch_assoc($res);

        // Verify the password using password_verify
        if (password_verify($password, $row['password'])) {
            // Set session for a successful login
            $_SESSION["login_sess"] = "1"; 
            $_SESSION["login_email"] = $login; // Store the login email in session
            $_SESSION["owner_id"] = $row['id']; // Store the owner ID
            $_SESSION["owner_name"] = $row['name']; // Store the owner's name

            // Redirect to owner dashboard or homepage
            header("Location: owner_dashboard.php");
            exit; // Ensure no further code is executed after redirect
        } else {
            // Invalid password, redirect back with an error
            header("Location: owner_login.php?error=invalid_password");
            exit;
        }
    } else {
        // Owner does not exist, redirect back with an error
        header("Location: owner_login.php?error=invalid_credentials");
        exit;
    }
}
?>
