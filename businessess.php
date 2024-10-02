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
$typeToSearch = "";

if (isset($_GET['search'])) {
    $nameToSearch = $_GET['nameToSearch'];
    $locationToSearch = $_GET['locationToSearch'];
    $typeToSearch = $_GET['typeToSearch'];

    // Build the base query for businesses
    $query = "SELECT name, location, details, type, famousFor, phoneNumber FROM businesses WHERE 1=1"; // Always true condition to append other conditions

    // Apply name and location filters
    if (!empty($nameToSearch)) {
        $query .= " AND name LIKE '%" . $nameToSearch . "%'";
    }
    if (!empty($locationToSearch)) {
        $query .= " AND location LIKE '%" . $locationToSearch . "%'";
    }

    // Filter by type
    if (!empty($typeToSearch)) {
        $query .= " AND type LIKE '%" . $typeToSearch . "%'";
    }

    $query .= " LIMIT $start_from, $limit"; // Add pagination limit
    $search_result = filterTable($query);
} else {
    $query = "SELECT name, location, details, type, famousFor, phoneNumber FROM businesses LIMIT $start_from, $limit"; // Default query with pagination
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
$totalQuery = "SELECT COUNT(*) FROM businesses";
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
    <title>Business Locator</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>

    <!-- Bootstrap Navbar -->
    <?php require('navbar.php') ?>
    

    <!-- Search Form -->
    <div class="container mt-4">
        <h1>Search Businesses</h1>
        <button class="btn btn-secondary mb-3" onclick="getLocation()">Detect My Location</button>
        <a class="mb-3 text-dark text-decoration-none" href="businessess.php">Refresh</a>
        <form method="get" action="">
            <div class="mb-3">
                <label for="nameToSearch" class="form-label">Business Name</label>
                <input type="text" name="nameToSearch" class="form-control" placeholder="Search by business name" value="<?php if (isset($nameToSearch)) { echo $nameToSearch; } ?>">
            </div>
            <div class="mb-3">
                <label for="locationToSearch" class="form-label">Location</label>
                <input type="text" id="locationToSearch" name="locationToSearch" class="form-control" placeholder="Search by location..." value="<?php if (isset($locationToSearch)) { echo $locationToSearch; } ?>">
            </div>
            <div class="mb-3">
                <label for="typeToSearch" class="form-label">Type</label>
                <input type="text" name="typeToSearch" class="form-control" placeholder="Search by business type..." value="<?php if (isset($typeToSearch)) { echo $typeToSearch; } ?>">
            </div>
            <button type="submit" name="search" class="btn btn-primary">Search</button>
        </form>

        <!-- Display Search Filters -->
        <?php if (isset($nameToSearch) || isset($locationToSearch) || isset($typeToSearch)) : ?>
            <div class="mt-3">
                <h5>You searched for:</h5>
                <p>
                    <?php
                    echo (!empty($nameToSearch)) ? "Business Name: " . $nameToSearch . " | " : "";
                    echo (!empty($locationToSearch)) ? "Location: " . $locationToSearch . " | " : "";
                    echo (!empty($typeToSearch)) ? "Type: " . $typeToSearch . " | " : "";
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
                            <p class="card-text">Details: <?php echo $row['details']; ?></p>
                            <p class="card-text">Type: <?php echo $row['type']; ?></p>
                            <p class="card-text">Famous For: <?php echo $row['famousFor']; ?></p>
                            <p class="card-text">Phone: <?php echo $row['phoneNumber']; ?></p>
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
                        <a class="page-link" href="<?php echo $_SERVER['PHP_SELF']; ?>?page=<?php echo $i; ?>&nameToSearch=<?php echo $nameToSearch; ?>&locationToSearch=<?php echo $locationToSearch; ?>&typeToSearch=<?php echo $typeToSearch; ?>">
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
