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
if (isset($_POST['add_college'])) {
    // Get the form data and sanitize inputs
    $name = mysqli_real_escape_string($dbc, $_POST['name']);
    $address = mysqli_real_escape_string($dbc, $_POST['address']);
    $location = mysqli_real_escape_string($dbc, $_POST['location']);
    $ranking = mysqli_real_escape_string($dbc, $_POST['ranking']);
    $type = mysqli_real_escape_string($dbc, $_POST['type']);
    $degree = mysqli_real_escape_string($dbc, $_POST['degree']);
    $affiliatedUniversity = mysqli_real_escape_string($dbc, $_POST['affiliatedUniversity']);

    // Retrieve owner_id from session
    if (isset($_SESSION["owner_id"])) {
        $owner_id = $_SESSION["owner_id"];

        // Check if the owner_id exists in the owners table
        $checkOwnerQuery = "SELECT * FROM owners WHERE id = '$owner_id'";
        $result = mysqli_query($dbc, $checkOwnerQuery);

        if (mysqli_num_rows($result) == 0) {
            die("The owner ID does not exist in the owners table.");
        }

        // Insert data into the colleges table
        $query = "INSERT INTO colleges (name, address, location, ranking, type, degree, affiliatedUniversity, owner_id) 
                  VALUES ('$name', '$address', '$location', '$ranking', '$type', '$degree', '$affiliatedUniversity', '$owner_id')";

        if (mysqli_query($dbc, $query)) {
            // Redirect to the same page with a success message
            header("Location: add_college.php?success=college_added");
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
    <title>Add College</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Auto redirect after success message -->
    <?php if (isset($_GET['success']) && $_GET['success'] == 'college_added'): ?>
    <script>
        // Wait 3 seconds, then redirect to the dashboard
        setTimeout(function(){
            window.location.href = 'owner_login.php';
        }, 3000);
    </script>
    <?php endif; ?>
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h1 class="text-center">Add New College</h1>

        <!-- Display success message -->
        <?php if (isset($_GET['success']) && $_GET['success'] == 'college_added'): ?>
            <div class="alert alert-success">
                College added successfully! Redirecting to dashboard...
            </div>
        <?php endif; ?>

        <form action="add_college.php" method="POST" class="mt-4">
            <div class="mb-3">
                <label for="name" class="form-label">College Name</label>
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
                <label for="ranking" class="form-label">Ranking</label>
                <input type="number" name="ranking" id="ranking" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="type" class="form-label">Type (Private/Public)</label>
                <input type="text" name="type" id="type" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="degree" class="form-label">Degree Offered</label>
                <input type="text" name="degree" id="degree" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="affiliatedUniversity" class="form-label">Affiliated University</label>
                <input type="text" name="affiliatedUniversity" id="affiliatedUniversity" class="form-control" required>
            </div>
            <div class="text-center">
                <button type="submit" name="add_college" class="btn btn-primary">Add College</button>
            </div>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
