<?php

include("database/config.php");
if (!isset($_SESSION['login_sess'])) {
    header('Location: signup.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head> <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Store Details</title>

    <!-- Add custom CSS for additional styling -->
    <style>
        .content-box {
            max-width: 800px;
            margin: auto;
            padding: 20px;
            border-radius: 10px;
            background-color: #f8f9fa;
        }

        .content-box h5,
        .content-box h6 {
            font-size: 1.25rem;
            text-align: center;
        }

        .custom-bg {
            background-color: #007bff;
        }

        /* Responsive settings */
        @media (max-width: 768px) {
            .content-box {
                padding: 15px;
            }

            .content-box h5,
            .content-box h6 {
                font-size: 1.1rem;
            }
        }

        @media (max-width: 576px) {
            .content-box h5,
            .content-box h6 {
                font-size: 1rem;
            }
        }
    </style>
</head>

<body class="bg-lights">
<?php require('navbar.php') ?>

<nav class="navbar navbar-light bg-light">
  <div class="container-fluid d-flex justify-content-center">
    <a class="navbar-brand custom-brand" href="#">General Stores</a>
  </div>
</nav>

<style>
  .custom-brand {
    font-size: 2.5rem; /* Adjust size as needed */
    font-weight: normal; /* Makes the text bold */
  }
</style>


    <?php
    if (!isset($_GET['id'])) {
        // Redirect to general_stores.php if no id is provided
        header('location : general_stores.php');
    } else {
        // Filter and retrieve store details based on the id from the URL
        $data = filteration($_GET);

        // Fetch the specific store data
        $store_res = select("SELECT * FROM general_stores WHERE id=?", [$data['id']], 'i');

        // If no store data is found, redirect back to general_stores.php
        if (mysqli_num_rows($store_res) == 0) {
            header('location : general_stores');
        }

        // Fetch the store data into an associative array
        $store_data = mysqli_fetch_assoc($store_res);
    }

    ?>

    <div class="container">
        <div class="row justify-content-center">
            
            <div class="col-lg-8 col-md-10 col-sm-12 my-3">
                <div class="content-box shadow-lg border-0">
                    <!-- Display all the store data attributes from the database -->
                    <h5>Store Name: <?php echo $store_data['name']; ?></h5>
                    <h6>Location: <?php echo $store_data['location']; ?></h6>
                    <h6>Details: <?php echo $store_data['details']; ?></h6>
                    <h6>Famous For: <?php echo $store_data['famous_for']; ?></h6>
                    <h6>Phone Number: <?php echo $store_data['phone_number']; ?></h6>
                    <h6><a href="<?php echo $store_data['map_url']; ?>" target="_blank">View on Map</a></h6>

                    <!-- Action Buttons -->
                </div>
            </div>
        </div>
    </div>
    <?php require('script.php'); ?>
</body>

</html>
