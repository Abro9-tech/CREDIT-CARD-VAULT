<?php
@include 'config.php'; // Include the database connection file
session_start(); // Start the session

// Check if the user is logged in as an employee
if (!isset($_SESSION['employee_name'])) {
    header('location: login.php'); // Redirect to login page if not logged in
    exit();
}

// SQL query to get all transactions
$query = "SELECT t.transaction_id, t.card_number, t.amount, t.description, u.user_name 
          FROM transactions t 
          JOIN users u ON t.user_id = u.user_id";

$result = mysqli_query($conn, $query); // Execute the query

// Check if any rows are returned
if (!$result) {
    die("Error fetching data: " . mysqli_error($conn)); // Display error message if the query fails
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee - View Transactions</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <div class="form-container">
        <h3>View Transactions</h3>

        <table>
            <thead>
                <tr>
                    <th>Transaction ID</th>
                    <th>Card Number</th>
                    <th>Amount</th>
                    <th>Description</th>
                    <th>User Name</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Loop through the rows and display transaction data
                while ($row = mysqli_fetch_assoc($result)) {
                    // Debugging: Uncomment this to inspect the row data
                    // echo "<pre>"; print_r($row); echo "</pre>";
                ?>
                    <tr>
                        <td><?php echo $row['transaction_id']; ?></td>
                        <td>
                            <?php
                            // Check if the card number is empty or null and display it accordingly
                            if (!empty($row['card_number'])) {
                                // Masking the card number to display the last 4 digits only
                                $masked_card_number = '**** **** **** ' . substr($row['card_number'], -4);
                                echo $masked_card_number; 
                            } else {
                                echo 'Card number unavailable'; // Fallback message if the card number is missing
                            }
                            ?>
                        </td>
                        <td><?php echo $row['amount']; ?></td>
                        <td><?php echo htmlspecialchars($row['description']); ?></td>
                        <td><?php echo htmlspecialchars($row['user_name']); ?></td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>

</body>
</html>






