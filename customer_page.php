<?php
session_start();

// Ensure that only customers can access this page
if ($_SESSION['role'] != 'user') {
    header('location: login_form.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Customer's Landing Page</title>
</head>
<body>

<h1>Welcome, Customer!</h1>
<p>Here are your available options:</p>
<ul>
    <li><a href="view_credit_cards.php">View Your Credit Cards</a></li>
    <li><a href="view_transactions.php">View Your Transactions</a></li>
    <li><a href="update_balance.php">Update Your Balance</a></li>
</ul>

<a href="logout.php">Logout</a>

</body>
</html>


