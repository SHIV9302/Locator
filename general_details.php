<?php

include("database/config.php");
if (!isset($_SESSION['login_sess'])) {
    header('Location: signup.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
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
