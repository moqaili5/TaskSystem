<?php
session_start();

// Include your database connection file
require_once "connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password =$_POST['password'];

    // Update the password in the database and clear the reset token
    $updatePasswordQuery = "UPDATE users SET password='$password', reset_token=NULL WHERE email='$email'";
    $connection->query($updatePasswordQuery);

    $_SESSION['resetSuccess'] = "Password reset successful. You can now log in with your new password.";
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
    <h2>Reset Password</h2>
    <?php
    if (isset($_SESSION['resetSuccess'])) {
        echo '<p style="color: green;">' . $_SESSION['resetSuccess'] . '</p>';
        unset($_SESSION['resetSuccess']);
    }
    ?>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <label for="email">Email:</label>
        <input type="email" name="email" value="<?php echo $_GET['email']; ?>" readonly>
        <label for="password">New Password:</label>
        <input type="password" name="password" required>
        <button type="submit">Reset Password</button>
    </form>
</body>
</html>
