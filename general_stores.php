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

if (isset($_GET['search'])) {
    $nameToSearch = $_GET['nameToSearch'];
    $locationToSearch = $_GET['locationToSearch'];

    // Build the base query for general stores
    $query = "SELECT id, name, location, details, famous_for, phone_number, map_url FROM general_stores WHERE 1=1"; // Always true condition to append other conditions

    // Apply name and location filters
    if (!empty($nameToSearch)) {
        $query .= " AND name LIKE '%" . $nameToSearch . "%'";
    }
    if (!empty($locationToSearch)) {
        $query .= " AND location LIKE '%" . $locationToSearch . "%'";
    }

    $query .= " LIMIT $start_from, $limit"; // Add pagination limit
    $search_result = filterTable($query);
} else {
    $query = "SELECT id, name, location, details, famous_for, phone_number, map_url FROM general_stores LIMIT $start_from, $limit"; // Default query with pagination
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
$totalQuery = "SELECT COUNT(*) FROM general_stores";
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
    <title>General Store Locator</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>

    <!-- Bootstrap Navbar -->
    <?php require('navbar.php') ?>

    <!-- Search Form -->
    <div class="container mt-4">
        <h1>Search General Stores</h1>
        <a class="mb-3 text-dark text-decoration-none " href="general_store.php">Refresh</a>
        <form method="get" action="">
            <div class="mb-3">
                <label for="nameToSearch" class="form-label">Store Name</label>
                <input type="text" name="nameToSearch" class="form-control" placeholder="Search by store names" value="<?php if (isset($nameToSearch)) { echo $nameToSearch; } ?>">
            </div>
            <div class="mb-3">
                <label for="locationToSearch" class="form-label">Location</label>
                <input type="text" id="locationToSearch" name="locationToSearch" class="form-control" placeholder="Search by location..." value="<?php if (isset($locationToSearch)) { echo $locationToSearch; } ?>">
            </div>
            <button type="submit" name="search" class="btn btn-primary">Search</button>
        </form>

        <!-- Display Search Filters -->
        <?php if (isset($nameToSearch) || isset($locationToSearch)) : ?>
            <div class="mt-3">
                <h5>You searched for:</h5>
                <p>
                    <?php
                    echo (!empty($nameToSearch)) ? "Store Name: " . $nameToSearch . " | " : "";
                    echo (!empty($locationToSearch)) ? "Location: " . $locationToSearch . " | " : "";
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
                            <p class="card-text">Famous For: <?php echo $row['famous_for']; ?></p>
                            <a href="<?php echo $row['map_url']; ?>" target="_blank" class="btn btn-link">View on Map</a>
                            <a href="general_details.php?id=<?php echo $row['id'];?>"> More details</a>

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
                        <a class="page-link" href="<?php echo $_SERVER['PHP_SELF']; ?>?page=<?php echo $i; ?>&nameToSearch=<?php echo $nameToSearch; ?>&locationToSearch=<?php echo $locationToSearch; ?>">
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
