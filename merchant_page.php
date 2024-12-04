<?php
@include 'config.php';
session_start();

// Ensure the user is logged in as a merchant
if(!isset($_SESSION['merchant_name'])){
   header('location:login_form.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Merchant Page</title>
   <link rel="stylesheet" href="css/style.css">
</head>
<body>
   <div class="container">
      <div class="content">
         <h3>Hi, <span>Merchant</span></h3>
         <h1>Welcome, <span><?php echo $_SESSION['merchant_name']; ?></span></h1>
         <p>This is the merchant page.</p>
         <a href="login_form.php" class="btn">Login</a>
         <a href="register_form.php" class="btn">Register</a>
         <a href="logout.php" class="btn">Logout</a>
      </div>
   </div>
</body>
</html>
