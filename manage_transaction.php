<?php
session_start();
if (!isset($_SESSION['employee_name'])) {
    header('Location: login.php');
    exit();
}

@include 'config.php'; // Include your database connection

// Process the form when submitted
if (isset($_POST['submit'])) {
    $card_number = mysqli_real_escape_string($conn, $_POST['card_number']);
    $card_cvv = mysqli_real_escape_string($conn, $_POST['card_cvv']);
    $amount = mysqli_real_escape_string($conn, $_POST['amount']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    
    // Encrypt sensitive data like card number and CVV
    $encrypted_card_number = openssl_encrypt($card_number, 'aes-256-cbc', 'secretkey', 0, '1234567890123456');
    $encrypted_card_cvv = openssl_encrypt($card_cvv, 'aes-256-cbc', 'secretkey', 0, '1234567890123456');
    
    // SQL query to insert a new transaction
    $insert = "INSERT INTO transactions (card_number, card_cvv, amount, description) VALUES ('$encrypted_card_number', '$encrypted_card_cvv', '$amount', '$description')";
    $result = mysqli_query($conn, $insert);
    
    if ($result) {
        $success_msg = "Transaction recorded successfully!";
    } else {
        $error_msg = "Failed to record transaction. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Transactions</title>
    <style>
        /* Include your styles here */
        /* For brevity, I'm using a simple inline style for now */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }
        .container {
            width: 80%;
            margin: auto;
            padding-top: 50px;
        }
        .form-container {
            background-color: white;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }
        .form-container input, .form-container textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }
        .form-container input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        .form-container input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Manage Transactions</h2>
        
        <?php if (isset($success_msg)) { echo '<p style="color: green;">' . $success_msg . '</p>'; } ?>
        <?php if (isset($error_msg)) { echo '<p style="color: red;">' . $error_msg . '</p>'; } ?>

        <div class="form-container">
            <form action="" method="POST">
                <label for="card_number">Card Number:</label>
                <input type="text" id="card_number" name="card_number" required>
                
                <label for="card_cvv">Card CVV:</label>
                <input type="text" id="card_cvv" name="card_cvv" required>
                
                <label for="amount">Amount:</label>
                <input type="number" id="amount" name="amount" required>
                
                <label for="description">Description:</label>
                <textarea id="description" name="description" rows="4" required></textarea>

                <input type="submit" name="submit" value="Submit Transaction">
            </form>
        </div>
    </div>

</body>
</html>

