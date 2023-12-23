<?php
session_start();
require_once "connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Update the password in the database
    $updatePasswordQuery = "UPDATE users SET password='$password', reset_token=NULL, reset_timestamp=NULL WHERE email='$email'";
    $connection->query($updatePasswordQuery);

    $_SESSION['resetSuccess'] = "Password reset successful. You can now log in with your new password.";
    header('Location: login.php');
    exit();
}

// Retrieve the token from the URL
$email = $_GET['email'];
$token = $_GET['token'];

// Check if the token is valid (you may want to add more validation)
$sql = "SELECT * FROM users WHERE email='$email' AND reset_token='$token'";
$result = $connection->query($sql);

if ($result->num_rows !== 1) {
    $_SESSION['resetError'] = "Invalid or expired reset token.";
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
</head>
<body>
    <?php
    // Display reset error or success message
    if (isset($_SESSION['resetError'])) {
        echo '<p style="color: red;">' . $_SESSION['resetError'] . '</p>';
        unset($_SESSION['resetError']);
    }
    ?>

    <h2>Reset Password</h2>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo $email; ?>" readonly>
        <label for="password">New Password:</label>
        <input type="password" name="password" required>
        <button type="submit">Reset Password</button>
    </form>
</body>
</html>
