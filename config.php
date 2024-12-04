<?php

// Database connection
$conn = mysqli_connect('localhost', 'root', '', 'credit_card_vault');

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
