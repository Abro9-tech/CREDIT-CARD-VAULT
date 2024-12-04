<?php
session_start();
if (!isset($_SESSION['employee_name'])) {
    header('Location: login.php');
    exit();
}

@include 'config.php'; // Include your database connection

// Fetch transaction history from the database
$select = "SELECT * FROM transactions ORDER BY transaction_date DESC";
$result = mysqli_query($conn, $select);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction History</title>
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
        <h2>Transaction History</h2>
        <table>
            <tr>
                <th>Transaction ID</th>
                <th>Amount</th>
                <th>Description</th>
                <th>Date</th>
            </tr>

            <?php
            while ($row = mysqli_fetch_array($result)) {
                echo "<tr>
                        <td>" . $row['transaction_id'] . "</td>
                        <td>" . $row['amount'] . "</td>
                        <td>" . $row['description'] . "</td>
                        <td>" . $row['transaction_date'] . "</td>
                      </tr>";
            }
            ?>
        </table>
    </div>

</body>
</html>
