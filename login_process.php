<?php 
require_once("database/config.php"); 

if(isset($_POST['sublogin'])) { 
  $login = $_POST['login_var'];
  $_SESSION["login_email"] = $login;
  $password = $_POST['password'];
  $query = "SELECT * FROM users WHERE (email = '$login')";
  $res = mysqli_query($dbc, $query);
  $numRows = mysqli_num_rows($res);
  
  if ($numRows == 1) {
    $row = mysqli_fetch_assoc($res);
    
    if (password_verify($password, $row['password'])) {
      $_SESSION["login_sess"] = "1"; 
      header("location:home_page.php");
    } else { 
      header("location:login.php?error=invalid_password");
    }
  } else {
    header("location:login.php?error=invalid_credentials");
  }
}
?>
