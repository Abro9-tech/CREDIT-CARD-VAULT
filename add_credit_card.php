<?php
@include 'config.php';

session_start();

// Check if the user is logged in and is a manager
if (!isset($_SESSION['user_name']) || $_SESSION['role'] != 'manager') {
    header('location: login_form.php');
    exit();
}

if (isset($_POST['submit'])) {
    $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
    $card_number = mysqli_real_escape_string($conn, $_POST['card_number']);
    $cvv = mysqli_real_escape_string($conn, $_POST['cvv']);
    $expiry_date = mysqli_real_escape_string($conn, $_POST['expiry_date']);
    $card_balance = mysqli_real_escape_string($conn, $_POST['card_balance']);

    // Ensure IV is 16 bytes long (AES-256-CBC needs a 16-byte IV)
    $iv = substr('your_iv_key_here', 0, 16);  // Replace 'your_iv_key_here' with your actual IV key (16 bytes)

    // Encrypt sensitive data
    $encrypted_card_number = openssl_encrypt($card_number, 'AES-256-CBC', 'your_encryption_key', 0, $iv);
    $encrypted_cvv = openssl_encrypt($cvv, 'AES-256-CBC', 'your_encryption_key', 0, $iv);

    // Check if the user exists in the users table
    $user_check_query = "SELECT * FROM users WHERE user_id = '$user_id'";
    $user_check_result = mysqli_query($conn, $user_check_query);

    if (mysqli_num_rows($user_check_result) > 0) {
        // Insert the new credit card for the user
        $insert_query = "INSERT INTO credit_card (user_id, card_number, cvv, expiry_date, card_balance) 
                         VALUES ('$user_id', '$encrypted_card_number', '$encrypted_cvv', '$expiry_date', '$card_balance')";

        if (mysqli_query($conn, $insert_query)) {
            echo "Credit card added successfully!";
        } else {
            echo "Error inserting credit card: " . mysqli_error($conn);
        }
    } else {
        echo "Error: User with ID $user_id does not exist.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Credit Cards</title>
    <link rel="stylesheet" href="css/style.css"> <!-- Link to your CSS -->
</head>
<body>
    <div class="form-container">
        <form action="" method="POST">
            <h3>Add a New Credit Card</h3>
            <input type="number" name="user_id" required placeholder="Enter User ID">
            <input type="text" name="card_number" required placeholder="Enter Card Number">
            <input type="number" name="cvv" required placeholder="Enter CVV">
            <input type="text" name="expiry_date" required placeholder="Enter Expiry Date (MM/YY)">
            <input type="number" name="card_balance" required placeholder="Enter Card Balance">
            <input type="submit" name="submit" value="Add Credit Card" class="form-btn">
        </form>
    </div>
</body>
</html>

