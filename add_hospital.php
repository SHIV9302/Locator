<?php
// Start the session
session_start();

// Check if the owner is logged in
if (!isset($_SESSION["login_sess"])) {
    header("Location: owner_login.php");
    exit;
}

// Include database connection
require_once("database/config.php");

// Handle form submission
if (isset($_POST['add_hospital'])) {
    // Get the form data and sanitize inputs
    $name = mysqli_real_escape_string($dbc, $_POST['name']);
    $address = mysqli_real_escape_string($dbc, $_POST['address']);
    $location = mysqli_real_escape_string($dbc, $_POST['location']);
    $rating = mysqli_real_escape_string($dbc, $_POST['rating']);
    $degree = mysqli_real_escape_string($dbc, $_POST['degree']);
    $years = mysqli_real_escape_string($dbc, $_POST['years']);
    $famous_for = mysqli_real_escape_string($dbc, $_POST['famous_for']);

    // Retrieve owner_id from session
    if (isset($_SESSION["owner_id"])) {
        $owner_id = $_SESSION["owner_id"];

        // Check if the owner_id exists in the owners table
        $checkOwnerQuery = "SELECT * FROM owners WHERE id = '$owner_id'";
        $result = mysqli_query($dbc, $checkOwnerQuery);

        if (mysqli_num_rows($result) == 0) {
            die("The owner ID does not exist in the owners table.");
        }

        // Insert data into the hospitals table
        $query = "INSERT INTO hospitals (name, address, location, rating, degree, years, owner_id, famousfor) 
                  VALUES ('$name', '$address', '$location', '$rating', '$degree', '$years', '$owner_id', '$famous_for')";

        if (mysqli_query($dbc, $query)) {
            // Redirect to the same page with a success message
            header("Location: add_hospital.php?success=hospital_added");
            exit;
        } else {
            echo "Error: " . mysqli_error($dbc); // Output any database error
        }
    } else {
        die("Owner not logged in. Please log in as an owner.");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Hospital</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h1 class="text-center">Add New Hospital</h1>
        
        <!-- Display success message -->
        <?php if (isset($_GET['success']) && $_GET['success'] == 'hospital_added'): ?>
            <div class="alert alert-success">
                Hospital added successfully!
            </div>
            <script>
        // Wait 3 seconds, then redirect to the dashboard
        setTimeout(function(){
            window.location.href = 'owner_login.php';
        }, 1000);
    </script>
        <?php endif; ?>
        
        <form action="add_hospital.php" method="POST" class="mt-4">
            <div class="mb-3">
                <label for="name" class="form-label">Hospital Name</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <input type="text" name="address" id="address" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="location" class="form-label">Location</label>
                <input type="text" name="location" id="location" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="rating" class="form-label">Rating</label>
                <input type="number" name="rating" id="rating" class="form-control" min="1" max="5" required>
            </div>
            <div class="mb-3">
                <label for="degree" class="form-label">Degree</label>
                <input type="text" name="degree" id="degree" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="years" class="form-label">Years of Experience</label>
                <input type="number" name="years" id="years" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="famous_for" class="form-label">Famous For</label>
                <input type="text" name="famous_for" id="famous_for" class="form-control" required>
            </div>
            <div class="text-center">
                <button type="submit" name="add_hospital" class="btn btn-primary">Add Hospital</button>
            </div>
        </form>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
