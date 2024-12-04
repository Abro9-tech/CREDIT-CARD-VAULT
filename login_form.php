<?php
@include 'config.php'; // Include database connection
session_start(); // Start the session

if (isset($_POST['submit'])) {
    // Get the form input data
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']); // Get the plain password
    $hashed_password = hash('sha256', $password); // Hash the password using SHA-256

    // SQL query to fetch the user based on email and hashed password
    $select = "SELECT * FROM users WHERE email = '$email' AND password = '$hashed_password'";

    // Execute the query
    $result = mysqli_query($conn, $select);

    // Check if the query ran successfully
    if (!$result) {
        echo "Error: " . mysqli_error($conn);
        exit;
    }

    // Check if a user was found
    if (mysqli_num_rows($result) > 0) {
        // Fetch user details
        $row = mysqli_fetch_array($result);

        // Check the user's role and redirect accordingly
        if ($row['role'] == 'manager') {
            $_SESSION['manager_name'] = $row['user_name'];
            $_SESSION['user_id'] = $row['user_id'];
            header('Location: manager_form.php');
            exit();
        } elseif ($row['role'] == 'customer') {
            $_SESSION['customer_name'] = $row['user_name'];
            $_SESSION['user_id'] = $row['user_id'];
            header('Location: customer_page.php');
            exit();
        } elseif ($row['role'] == 'employee') {
            $_SESSION['employee_name'] = $row['user_name'];
            $_SESSION['user_id'] = $row['user_id'];
            header('Location: employee_page.php');
            exit();
        } else {
            $error[] = 'Unknown role! Please check the user role in the database.';
        }
    } else {
        $error[] = 'Incorrect email or password!';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Login</title>
   <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="form-container">
   <form action="" method="post">
      <h3>Login Now</h3>

      <?php
         // Show error messages, if any
         if (isset($error)) {
            foreach ($error as $error) {
               echo '<span class="error-msg">' . $error . '</span>';
            }
         }
      ?>

      <input type="email" name="email" required placeholder="Enter your email">
      <input type="password" name="password" required placeholder="Enter your password">
      <input type="submit" name="submit" value="Login Now" class="form-btn">
      <p>Don't have an account? <a href="register_form.php">Register now</a></p>
   </form>
</div>

</body>
</html>



