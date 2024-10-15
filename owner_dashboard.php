<?php
// Start the session
session_start();

// Check if the owner is logged in
if (!isset($_SESSION["login_sess"])) {
    header("location:owner_login.php");
    exit;
}

// Include database connection
require_once("database/config.php");

// Fetch the owner's details
$login_email = $_SESSION["login_email"];
$query = "SELECT * FROM owners WHERE email = '$login_email'";
$result = mysqli_query($dbc, $query);
$owner = mysqli_fetch_assoc($result);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Owner Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h1 class="text-center">Welcome, <?php echo $owner['name']; ?>!</h1>
        <p class="text-center">What would you like to add?</p>

        <!-- Options to Add Various Entities -->
        <div class="row justify-content-center mt-4">
            <div class="col-md-8">
                <div class="d-grid gap-3">
                    <a href="add_hospital.php" class="btn btn-primary">Add Hospital</a>
                    <a href="add_college.php" class="btn btn-secondary">Add College</a>
                    <a href="add_hotel.php" class="btn btn-success">Add Hotel</a>
                    <a href="add_restaurant.php" class="btn btn-warning">Add Restaurant</a>
                    <a href="add_general_store.php" class="btn btn-info">Add General Store</a>
                    <a href="add_business.php" class="btn btn-dark">Add Business</a>
                </div>
            </div>
        </div>

        <!-- Logout Button -->
        <div class="text-center mt-4">
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
