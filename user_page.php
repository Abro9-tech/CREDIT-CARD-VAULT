<?php

@include 'config.php';

session_start();

// Ensure user is logged in
if(!isset($_SESSION['user_name'])){
   header('location:login_form.php');
}

// Fetch user details
$user_id = $_SESSION['user_id'];

if(isset($_POST['add_card'])){
   $card_number = mysqli_real_escape_string($conn, $_POST['card_number']);
   $cvv = mysqli_real_escape_string($conn, $_POST['cvv']);
   $expiry_date = mysqli_real_escape_string($conn, $_POST['expiry_date']);
   $balance = mysqli_real_escape_string($conn, $_POST['balance']);

   // Encrypt sensitive data
   $encrypted_card_number = openssl_encrypt($card_number, 'AES-256-CBC', $encryption_key, 0, $iv);
   $encrypted_cvv = openssl_encrypt($cvv, 'AES-256-CBC', $encryption_key, 0, $iv);
   $encrypted_expiry_date = openssl_encrypt($expiry_date, 'AES-256-CBC', $encryption_key, 0, $iv);

   // Insert encrypted data into the credit_card table
   $insert_card = "INSERT INTO credit_card(user_id, card_number, cvv, expiry_date, card_balance) 
                   VALUES('$user_id', '$encrypted_card_number', '$encrypted_cvv', '$encrypted_expiry_date', '$balance')";
   mysqli_query($conn, $insert_card);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Customer Dashboard</title>
   <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="container">
   <h1>Welcome, <?php echo $_SESSION['user_name']; ?></h1>
   <p>This is your dashboard</p>

   <h2>Add Your Credit Card Details</h2>
   <form action="" method="post">
      <input type="text" name="card_number" required placeholder="Card Number">
      <input type="text" name="cvv" required placeholder="CVV">
      <input type="text" name="expiry_date" required placeholder="Expiry Date (MM/YY)">
      <input type="text" name="balance" required placeholder="Card Balance">
      <input type="submit" name="add_card" value="Add Card" class="form-btn">
   </form>
</div>

</body>
</html>
