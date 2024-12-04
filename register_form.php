<?php
@include 'config.php';
session_start();

if (isset($_POST['submit'])) {
    $user_name = mysqli_real_escape_string($conn, $_POST['user_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']); 
    $role = mysqli_real_escape_string($conn, $_POST['role']); // Get selected role
    $hashed_password = hash('sha256', $password); // Hash the password using SHA-256

    // Check if the email is already registered
    $select = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $select);

    if (mysqli_num_rows($result) > 0) {
        $error[] = 'Email already taken, try another!';
    } else {
        // Insert new user data into the users table
        $insert = "INSERT INTO users (user_name, email, password, role) VALUES ('$user_name', '$email', '$hashed_password', '$role')";
        if (mysqli_query($conn, $insert)) {
            $success[] = 'Registration successful! You can now log in.';
        } else {
            $error[] = 'Failed to register, please try again!';
        }
    }
};

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Register</title>
   <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="form-container">
   <form action="" method="post">
      <h3>Register Now</h3>

      <?php
         if (isset($error)) {
            foreach ($error as $error) {
               echo '<span class="error-msg">' . $error . '</span>';
            }
         }
         if (isset($success)) {
            foreach ($success as $success) {
               echo '<span class="success-msg">' . $success . '</span>';
            }
         }
      ?>

      <input type="text" name="user_name" required placeholder="Enter your username">
      <input type="email" name="email" required placeholder="Enter your email">
      <input type="password" name="password" required placeholder="Enter your password">
      
      <!-- Role Selection -->
      <label for="role">Select your role:</label>
      <select name="role" required>
         <option value="customer">customer</option>
         <option value="manager">Manager</option>
         <option value="employee">employee</option>
      </select>

      <input type="submit" name="submit" value="Register Now" class="form-btn">
      <p>Already have an account? <a href="login_form.php">Login now</a></p>
   </form>
</div>

</body>
</html>


