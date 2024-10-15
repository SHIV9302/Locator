<?php
include("database/config.php");
if (!isset($_SESSION['login_sess'])) {
    header('Location: signup.php');
}

$limit = 9; // Number of records per page
if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}
$start_from = ($page - 1) * $limit;

// Initialize search variables
$nameToSearch = "";
$locationToSearch = "";
$ratingToSearch = "";


if (isset($_GET['search'])) {
    $nameToSearch = $_GET['nameToSearch'];
    $locationToSearch = $_GET['locationToSearch'];
    $ratingToSearch = $_GET['ratingToSearch'];

    // Build the base query
    $query = "SELECT name, location, rating, map_link FROM hotels WHERE 1=1"; // Always true condition to append other conditions

    // Apply name and location filters
    if (!empty($nameToSearch)) {
        $query .= " AND name LIKE '%" . $nameToSearch . "%'";
    }
    if (!empty($locationToSearch)) {
        $query .= " AND location LIKE '%" . $locationToSearch . "%'";
    }

    // Filter by rating
    if (!empty($ratingToSearch)) {
        $queryExact = $query . " AND rating = '" . $ratingToSearch . "'";
        $search_result = filterTable($queryExact);

        if (mysqli_num_rows($search_result) == 0) {
            $query .= " ORDER BY ABS(rating - '" . $ratingToSearch . "') LIMIT 5"; // Fetch the 5 nearest values
            $search_result = filterTable($query);
        }
    } else {
        $query .= " LIMIT $start_from, $limit"; // Add pagination limit
        $search_result = filterTable($query);
    }
} else {
    $query = "SELECT id,name, location, rating, map_link FROM hotels LIMIT $start_from, $limit"; // Default query with pagination
    $search_result = filterTable($query);
}

// Function to execute the query
function filterTable($query)
{
    $connect = mysqli_connect("localhost:3307", "root", "", "locator");
    $filter_Result = mysqli_query($connect, $query);
    return $filter_Result;
}

// Get total records for pagination
$totalQuery = "SELECT COUNT(*) FROM hotels";
$total_result = filterTable($totalQuery);
$total_records = mysqli_fetch_array($total_result)[0];
$total_pages = ceil($total_records / $limit);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Locator</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition, showError);
            } else {
                alert("Geolocation is not supported by this browser.");
            }
        }

        function showPosition(position) {
            let lat = position.coords.latitude;
            let long = position.coords.longitude;
            $.ajax({
                url: `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${long}`,
                type: "GET",
                success: function(result) {
                    let location = result.address.city;
                    if (location) {
                        $('#locationToSearch').val(location);
                    } else {
                        alert("Location could not be detected.");
                    }
                },
                error: function() {
                    alert("Error retrieving location information.");
                }
            });
        }

        function showError(error) {
            switch (error.code) {
                case error.PERMISSION_DENIED:
                    alert("User denied the request for Geolocation.");
                    break;
                case error.POSITION_UNAVAILABLE:
                    alert("Location information is unavailable.");
                    break;
                case error.TIMEOUT:
                    alert("The request to get user location timed out.");
                    break;
                case error.UNKNOWN_ERROR:
                    alert("An unknown error occurred.");
                    break;
            }
        }
    </script>
</head>

<body>

    <!-- Bootstrap Navbar -->
    <?php require('navbar.php') ?>

    
<div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="Assets/hotel3.jpg" class="d-block w-100" style="height: 400px; object-fit: cover;" alt="...">
    </div>
    <div class="carousel-item">
      <img src="Assets/hotel2.jpg" class="d-block w-100" style="height: 400px; object-fit: cover;" alt="...">
    </div>
    <div class="carousel-item">
      <img src="Assets/hotel3.jpg" class="d-block w-100" style="height: 400px; object-fit: cover;" alt="...">
    </div>
  </div>
</div>


    <!-- Search Form -->
    <div class="container mt-4">
        <h1>Search Hotels</h1>
        <button class="btn btn-secondary mb-3" onclick="getLocation()">Detect My Location</button>
        <a class="mb-3 text-dark text-decoration-none " href="hotel.php">Refresh</a>
        <form method="get" action="">
            <div class="mb-3">
                <label for="nameToSearch" class="form-label">Hotel Name</label>
                <input type="text" name="nameToSearch" class="form-control" placeholder="Search by Hotel names" value="<?php if (isset($nameToSearch)) {
                                                                                                                            echo $nameToSearch;
                                                                                                                        } ?>">
            </div>
            <div class="mb-3">
                <label for="locationToSearch" class="form-label">Location</label>
                <input type="text" id="locationToSearch" name="locationToSearch" class="form-control" placeholder="Search by location..." value="<?php if (isset($locationToSearch)) {
                                                                                                                                                        echo $locationToSearch;
                                                                                                                                                    } ?>">
            </div>
            <div class="mb-3">
                <label for="ratingToSearch" class="form-label">Rating</label>
                <input type="text" name="ratingToSearch" class="form-control" placeholder="Search by rating..." value="<?php if (isset($ratingToSearch)) {
                                                                                                                            echo $ratingToSearch;
                                                                                                                        } ?>">
            </div>
            <button type="submit" name="search" class="btn btn-primary">Search</button>
        </form>

        <!-- Display Search Filters -->
        <?php if (isset($nameToSearch) || isset($locationToSearch) || isset($ratingToSearch)) : ?>
            <div class="mt-3">
                <h5>You searched for:</h5>
                <p>
                    <?php
                    echo (!empty($nameToSearch)) ? "Hotel Name: " . $nameToSearch . " | " : "";
                    echo (!empty($locationToSearch)) ? "Location: " . $locationToSearch . " | " : "";
                    echo (!empty($ratingToSearch)) ? "Rating: " . $ratingToSearch . " | " : "";
                    ?>
                </p>
            </div>
        <?php endif; ?>

        <!-- Card Layout for Search Results -->
        <div class="row row-cols-1 row-cols-md-3 g-4 mt-3">
            <?php while ($row = mysqli_fetch_array($search_result)) : ?>
                <div class="col">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $row['name']; ?></h5>
                            <p class="card-text">Location: <?php echo $row['location']; ?></p>
                            <p class="card-text">Rating: <?php echo $row['rating']; ?></p>
                            <a href="<?php echo $row['map_link']; ?>" target="_blank" class="btn btn-outline-primary">View Map</a>
                            <a href="hotel_detail.php?id=<?php echo $row['id'];?>"> More details</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>

        <!-- Pagination -->
        <nav aria-label="Page navigation example" class="mt-4">
            <ul class="pagination justify-content-center">
                <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                    <li class="page-item <?php if ($i == $page) {
                                                echo 'active';
                                            } ?>">
                        <a class="page-link" href="<?php echo $_SERVER['PHP_SELF']; ?>?page=<?php echo $i; ?>&nameToSearch=<?php echo $nameToSearch; ?>&locationToSearch=<?php echo $locationToSearch; ?>&ratingToSearch=<?php echo $ratingToSearch; ?>">
                            <?php echo $i; ?>
                        </a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>

    </div>

    <?php require('script.php'); ?>


</body>

</html>