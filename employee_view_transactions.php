<?php
session_start();
if (!isset($_SESSION['employee_name'])) {
    header('Location: login.php');
    exit();
}

@include 'config.php'; // Include your database connection

// Fetch all transactions
$select = "SELECT * FROM transactions";
$result = mysqli_query($conn, $select);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Transactions</title>
    <style>
        /* Simple inline CSS for the table */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>View Transactions</h2>
        <table>
            <tr>
                <th>Transaction ID</th>
                <th>Card Number</th>
                <th>Amount</th>
                <th>Description</th>
            </tr>

            <?php
            while ($row = mysqli_fetch_array($result)) {
                // Decrypt the sensitive data
                $card_number = openssl_decrypt($row['card_number'], 'aes-256-cbc', 'secretkey', 0, '1234567890123456');
                $card_cvv = openssl_decrypt($row['card_cvv'], 'aes-256-cbc', 'secretkey', 0, '1234567890123456');
                echo "<tr>
                        <td>" . $row['transaction_id'] . "</td>
                        <td>" . $card_number . "</td>
                        <td>" . $row['amount'] . "</td>
                        <td>" . $row['description'] . "</td>
                      </tr>";
            }
            ?>
        </table>
    </div>

</body>
</html>
