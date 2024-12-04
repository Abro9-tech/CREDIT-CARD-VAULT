<?php
session_start();
if (!isset($_SESSION['employee_name'])) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Landing Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .header {
            background-color: #4CAF50;
            color: white;
            padding: 20px;
            text-align: center;
        }

        .nav {
            background-color: #333;
            overflow: hidden;
        }

        .nav button {
            float: left;
            display: block;
            color: white;
            padding: 14px 20px;
            text-align: center;
            text-decoration: none;
            font-size: 17px;
            border: none;
            background-color: #333;
        }

        .nav button:hover {
            background-color: #ddd;
            color: black;
        }

        .nav button:active {
            background-color: #4CAF50;
            color: white;
        }

        .content {
            padding: 20px;
            background-color: white;
            margin: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .logout-btn {
            background-color: #f44336;
            color: white;
            padding: 15px 20px;
            border: none;
            text-align: center;
            display: block;
            width: 100%;
            margin-top: 20px;
            cursor: pointer;
            font-size: 18px;
            border-radius: 5px;
        }

        .logout-btn:hover {
            background-color: #e53935;
        }

        .logout-btn:active {
            background-color: #d32f2f;
        }

        .container {
            width: 80%;
            margin: 0 auto;
        }

        h1 {
            color: #333;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>Welcome, <?php echo $_SESSION['employee_name']; ?> (Employee)</h1>
    </div>

    <div class="container">
        <div class="nav">
            <button onclick="window.location.href='manage_transaction.php'">Manage Transactions</button>
            <button onclick="window.location.href='employee_view_transactions.php'">View Transactions</button>
            <button onclick="window.location.href='employee_view_credit.php'">View Credit Cards</button>
            <button onclick="window.location.href='transactions_history.php'">Transaction History</button>
        </div>

        <div class="content">
            <h2>Welcome to the Employee Portal</h2>
            <p>From here, you can manage transactions, view credit card details, and access transaction history.</p>
        </div>

        <!-- Log out button at the bottom -->
        <form action="logout.php" method="POST">
            <button type="submit" class="logout-btn">Log Out</button>
        </form>
    </div>

</body>
</html>


    