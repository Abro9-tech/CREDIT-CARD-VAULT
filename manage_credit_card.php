<?php
session_start();

// Check if the user is logged in as a manager
if (!isset($_SESSION['manager_name'])) {
    header('Location: login_form.php');
    exit;
}

// Database connection
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if we're adding a new credit card
    if (isset($_POST['add_card'])) {
        $user_id = $_POST['user_id'];
        $card_number = $_POST['card_number'];
        $cvv = $_POST['cvv'];
        $expiry_date = $_POST['expiry_date'];
        $card_balance = $_POST['card_balance'];

        // Check if the user_id exists in the users table
        $check_user_sql = "SELECT * FROM users WHERE user_id = '$user_id'";
        $check_user_result = mysqli_query($conn, $check_user_sql);

        if (mysqli_num_rows($check_user_result) > 0) {
            // Encrypt card number, CVV, and expiry date
            $key = 'your-encryption-key'; // Change this to your own encryption key
            $iv = openssl_random_pseudo_bytes(16); // 16-byte initialization vector

            $encrypted_card_number = openssl_encrypt($card_number, 'AES-256-CBC', $key, 0, $iv);
            $encrypted_cvv = openssl_encrypt($cvv, 'AES-256-CBC', $key, 0, $iv);
            $encrypted_expiry_date = openssl_encrypt($expiry_date, 'AES-256-CBC', $key, 0, $iv);

            // Insert the new credit card into the database
            $sql = "INSERT INTO credit_card (user_id, card_number, cvv, expiry_date, card_balance) 
                    VALUES ('$user_id', '$encrypted_card_number', '$encrypted_cvv', '$encrypted_expiry_date', '$card_balance')";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                echo "Credit card added successfully!";
            } else {
                echo "Error: " . mysqli_error($conn);
            }
        } else {
            echo "Error: User with ID $user_id does not exist!";
        }
    }

    // Check if we're updating an existing credit card
    if (isset($_POST['update_balance'])) {
        $card_id = $_POST['card_id'];
        $new_balance = $_POST['new_balance'];

        // Update the card balance
        $sql = "UPDATE credit_card SET card_balance = '$new_balance' WHERE card_id = '$card_id'";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            echo "Card balance updated successfully!";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}

// Retrieve all users for the add card form
$sql = "SELECT * FROM users";
$users_result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Credit Cards</title>
    
    <style>
        /* CSS styles for page layout */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 70%;
            margin: 50px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            font-size: 28px;
            color: #333;
            margin-bottom: 20px;
            text-align: center;
        }
        form {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
        }
        input, select {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            margin: 10px 0;
            background-color: #f2f2f2;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .btn {
            display: inline-block;
            background-color: #333;
            color: #fff;
            padding: 12px 30px;
            text-transform: capitalize;
            text-align: center;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .btn:hover {
            background-color: crimson;
        }
        .btn-container {
            text-align: center;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Manage Credit Cards</h1>

    <!-- Add New Card Form -->
    <h2>Add New Credit Card</h2>
    <form method="POST" action="">
        <label for="user_id">User ID:</label>
        <input type="text" name="user_id" id="user_id" required>

        <label for="card_number">Card Number:</label>
        <input type="text" name="card_number" id="card_number" required>

        <label for="cvv">CVV:</label>
        <input type="text" name="cvv" id="cvv" required>

        <label for="expiry_date">Expiry Date:</label>
        <input type="text" name="expiry_date" id="expiry_date" required>

        <label for="card_balance">Card Balance:</label>
        <input type="number" name="card_balance" id="card_balance" required>

        <input type="submit" name="add_card" value="Add Card" class="btn">
    </form>

    <hr>

    <!-- Update Card Balance Form -->
    <h2>Update Card Balance</h2>
    <form method="POST" action="">
        <label for="card_id">Card ID:</label>
        <input type="text" name="card_id" id="card_id" required>

        <label for="new_balance">New Balance:</label>
        <input type="number" name="new_balance" id="new_balance" required>

        <input type="submit" name="update_balance" value="Update Balance" class="btn">
    </form>

    <div class="btn-container">
        <a href="manager_form.php" class="btn">Back to Dashboard</a>
    </div>
</div>

</body>
</html>










