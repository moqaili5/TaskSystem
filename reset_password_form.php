<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
</head>
<body>
    <h2>Reset Password</h2>
    <form action="update_password.php" method="post">
        <label for="password">New Password:</label>
        <input type="password" name="password" required>
        <input type="hidden" name="email" value="<?php echo $_GET['email']; ?>">
        <input type="hidden" name="token" value="<?php echo $_GET['token']; ?>">
        <input type="submit" value="Reset Password">
    </form>
</body>
</html>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['email'], $_POST['token'], $_POST['password'])) {
        $email = $_POST['email'];
        $token = $_POST['token'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        // Validate the token and check its expiration
        $query = "SELECT * FROM users WHERE email = :email AND reset_token = :token AND reset_token_expiration >= NOW()";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':token', $token);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Update the password and remove the token
            $query = "UPDATE users SET password = :password, reset_token = NULL, reset_token_expiration = NULL WHERE email = :email";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            echo "Password reset successful. You can now log in with your new password.";
        } else {
            echo "Invalid token or expired link.";
        }
    }
}
?>
