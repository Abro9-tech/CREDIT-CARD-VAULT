<?php
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['customer_id'])) {
    header('Location: login.php');
    exit;
}

include 'db_connection.php';

$customer_id = $_SESSION['customer_id'];

// Fetch credit cards for this customer
$sql = "SELECT * FROM credit_card WHERE user_id = '$customer_id'";
$result = mysqli_query($conn, $sql);

$key = 'your-encryption-key'; // Same encryption key used to encrypt the data

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Credit Cards</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f4f4f4;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>View Credit Cards</h1>
    <table>
        <thead>
            <tr>
                <th>Card Number</th>
                <th>Card Balance</th>
                <th>CVV</th>
                <th>Expiry Date</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($card = mysqli_fetch_assoc($result)) {
                // Decrypt card details
                $iv_card_number = substr($card['iv_card_number'], 0, 16);
                $iv_cvv = substr($card['iv_cvv'], 0, 16);
                $iv_expiry_date = substr($card['iv_expiry_date'], 0, 16);

                $decrypted_card_number = openssl_decrypt($card['card_number'], 'AES-256-CBC', $key, 0, $iv_card_number);
                $decrypted_cvv = openssl_decrypt($card['cvv'], 'AES-256-CBC', $key, 0, $iv_cvv);
                $decrypted_expiry_date = openssl_decrypt($card['expiry_date'], 'AES-256-CBC', $key, 0, $iv_expiry_date);

                ?>
                <tr>
                    <td><?php echo $decrypted_card_number; ?></td>
                    <td><?php echo $card['card_balance']; ?></td>
                    <td><?php echo $decrypted_cvv; ?></td>
                    <td><?php echo $decrypted_expiry_date; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

</body>
</html>
