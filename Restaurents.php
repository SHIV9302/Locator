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
$famousForToSearch = "";


if (isset($_GET['search'])) {
    $nameToSearch = $_GET['nameToSearch'];
    $locationToSearch = $_GET['locationToSearch'];
    $ratingToSearch = $_GET['ratingToSearch'];
    $famousForToSearch = $_GET['famousForToSearch'];

    // Build the base query for restaurants
    $query = "SELECT id,name, location, rating, mapLink, famousFor FROM restaurants WHERE 1=1"; // Always true condition to append other conditions

    // Apply name and location filters
    if (!empty($nameToSearch)) {
        $query .= " AND name LIKE '%" . $nameToSearch . "%'";
    }
    if (!empty($locationToSearch)) {
        $query .= " AND location LIKE '%" . $locationToSearch . "%'";
    }
    if (!empty($famousForToSearch)) {
        $query .= " AND famousFor LIKE '%" . $famousForToSearch . "%'";
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
    $query = "SELECT id, name, location, rating, mapLink, famousFor FROM restaurants LIMIT $start_from, $limit"; // Default query with pagination
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
$totalQuery = "SELECT COUNT(*) FROM restaurants";
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
    <title>Restaurant Locator</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>

    <!-- Bootstrap Navbar -->
    <?php require('navbar.php') ?>


    <!-- Search Form -->
    <div class="container mt-4">
        <h1>Search Restaurants</h1>
        <button class="btn btn-secondary mb-3" onclick="getLocation()">Detect My Location</button>
        <a class="mb-3 text-dark text-decoration-none " href="restaurants.php">Refresh</a>
        <form method="get" action="">
            <div class="mb-3">
                <label for="nameToSearch" class="form-label">Restaurant Name</label>
                <input type="text" name="nameToSearch" class="form-control" placeholder="Search by restaurant name" value="<?php if (isset($nameToSearch)) { echo $nameToSearch; } ?>">
            </div>
            <div class="mb-3">
                <label for="locationToSearch" class="form-label">Location</label>
                <input type="text" id="locationToSearch" name="locationToSearch" class="form-control" placeholder="Search by location..." value="<?php if (isset($locationToSearch)) { echo $locationToSearch; } ?>">
            </div>
            <div class="mb-3">
                <label for="famousForToSearch" class="form-label">famousFor</label>
                <input type="text" id="famousForToSearch" name="famousForToSearch" class="form-control" placeholder="Search by famousFor..." value="<?php if (isset($famousForToSearch)) { echo $famousForToSearch; } ?>">
            </div>
            <div class="mb-3">
                <label for="ratingToSearch" class="form-label">Rating</label>
                <input type="text" name="ratingToSearch" class="form-control" placeholder="Search by rating..." value="<?php if (isset($ratingToSearch)) { echo $ratingToSearch; } ?>">
            </div>
            <button type="submit" name="search" class="btn btn-primary">Search</button>
        </form>

        <!-- Display Search Filters -->
        <?php if (isset($nameToSearch) || isset($locationToSearch) || isset($ratingToSearch)) : ?>
            <div class="mt-3">
                <h5>You searched for:</h5>
                <p>
                    <?php
                    echo (!empty($nameToSearch)) ? "Restaurant Name: " . $nameToSearch . " | " : "";
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
                            <p class="card-text">Famous For: <?php echo $row['famousFor']; ?></p>
                            <a href="<?php echo $row['mapLink']; ?>" target="_blank" class="btn btn-primary">View on Map</a>
                            <a href="rest_details.php?id=<?php echo $row['id'];?>"> More details</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>

        <!-- Pagination -->
        <nav aria-label="Page navigation example" class="mt-4">
            <ul class="pagination justify-content-center">
                <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                    <li class="page-item <?php if ($i == $page) { echo 'active'; } ?>">
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
