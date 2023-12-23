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
