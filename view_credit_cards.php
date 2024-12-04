<?php
@include 'config.php'; // Include database connection
session_start();

// Check if the user is logged in and has a manager role
if (!isset($_SESSION['manager_name'])) {
    header('location: login.php');
    exit();
}

// Fetch transaction details with proper join
$query = "SELECT t.transaction_id, t.amount, t.description, c.card_number, u.user_name
          FROM transactions t
          JOIN credit_card c ON t.card_id = c.card_id
          JOIN users u ON c.user_id = u.user_id";  // Ensure this JOIN is correct

$result = mysqli_query($conn, $query);

// Check if the query was successful
if (!$result) {
    die("Error: " . mysqli_error($conn)); // Handle query errors
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Transactions</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h3>View All Transactions</h3>

    <?php
    // Display the transaction details in a table
    if (mysqli_num_rows($result) > 0) {
        echo '<table>';
        echo '<tr><th>Transaction ID</th><th>Card Number</th><th>Amount</th><th>Description</th><th>User Name</th></tr>';

        // Loop through each row in the result and display the data
        while ($row = mysqli_fetch_array($result)) {
            $card_number = $row['card_number']; // Card number

            // Display the table row for each transaction
            echo "<tr>
                    <td>" . $row['transaction_id'] . "</td>
                    <td>" . $card_number . "</td> <!-- Display the full card number -->
                    <td>" . $row['amount'] . "</td>
                    <td>" . $row['description'] . "</td>
                    <td>" . $row['user_name'] . "</td>
                  </tr>";
        }
        echo '</table>';
    } else {
        echo '<p>No transactions found.</p>';
    }
    ?>
    
    <br>
    <a href="manager_page.php">Back to Manager Dashboard</a>  <!-- Link to go back to manager dashboard -->
</div>

</body>
</html>

<?php
mysqli_close($conn); // Close the database connection
?>

?>























