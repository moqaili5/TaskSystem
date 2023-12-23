<?php
session_start();

// Include your database connection file
require_once "connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    // Validate email (you may want to add more validation)
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['resetError'] = "Invalid email format";
        header('Location: resetPassword.php');
        exit();
    }

    // Check if the email exists in the database
     $sql = "SELECT * FROM users WHERE email='$email'";
     $result = $connection->query($sql);

    if ($result !== false && $result->num_rows == 1) {
        // Generate a unique token
        $token = bin2hex(random_bytes(32));

        // Store the token in the database
        $sql = "UPDATE users SET reset_token='$token' WHERE email='$email'";
        $connection->query($sql);

        // Provide a link for the user to reset their password
        $resetLink = "localhost/finalProject/resetPasswordConfirm.php?email=$email&token=$token";

        $_SESSION['resetSuccess'] = "Visit the following link to reset your password: $resetLink";
        header('Location: login.php');
        exit();
    } else {
        $_SESSION['resetError'] = "Email not found in our records";
        header('Location: resetPassword.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset</title>
</head>
<body>
    <?php
    // Display reset error or success message
    if (isset($_SESSION['resetError'])) {
        echo '<p style="color: red;">' . $_SESSION['resetError'] . '</p>';
        unset($_SESSION['resetError']);
    }

    if (isset($_SESSION['resetSuccess'])) {
        echo '<p style="color: green;">' . $_SESSION['resetSuccess'] . '</p>';
        unset($_SESSION['resetSuccess']);
    }
    ?>

    <h2>Reset Password</h2>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <button type="submit">Reset Password</button>
    </form>
</body>
</html>
