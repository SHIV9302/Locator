<?php
// Start the session if it hasn't been started already
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Database configuration
$dbHost = 'localhost:3307';
$dbName = 'locator';
$dbUsername = 'root';
$dbPassword = '';

// Create database connection
$dbc = mysqli_connect($dbHost, $dbUsername, $dbPassword, $dbName);

// Function to sanitize input data
function filteration($data) {
    foreach ($data as $key => $value) {
        $data[$key] = trim($value);
        $data[$key] = stripslashes($value);
        $data[$key] = htmlspecialchars($value);
        $data[$key] = strip_tags($value);
    }
    return $data;
}

// Function to execute select queries
function select($sql, $values, $datatypes) {
    $con = $GLOBALS['dbc'];
    if ($stmt = mysqli_prepare($con, $sql)) {
        mysqli_stmt_bind_param($stmt, $datatypes, ...$values);
        if (mysqli_stmt_execute($stmt)) {
            $res = mysqli_stmt_get_result($stmt);
            mysqli_stmt_close($stmt);
            return $res;
        } else {
            mysqli_stmt_close($stmt);
            die("Query cannot be executed - Select");
        }
    } else {
        die("Query cannot be prepared - Select");
    }
}
?>
