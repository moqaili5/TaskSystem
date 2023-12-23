<?php
session_start();
if (!isset($_SESSION['logged-in'])) {
    header('Location: login.php');
    exit();
}

require_once "connect.php";

$connection = new mysqli($host, $db_user, $db_password, $db_name);

if ($connection->connect_errno != 0) {
    echo "Error: " . $connection->connect_errno . "<br>";
    echo "Description: " . $connection->connect_error;
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #EAFAF1;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }
        .form-group label {
            font-weight: bold;
        }
    </style>
</head>
<body>
<?php
$user_id = $_SESSION['user'];
$sql = "SELECT * FROM users WHERE User_id='$user_id'";
$result = $connection->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $updateUsername = $row['Username'];
        $updateUseremail = $row['Email'];
        $updateUserpassword = $row['Password'];
        $imageURL = "images/" . $row['User_Photo'];
        
    }
}
?>
<!-- This form to update user information -->
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6 border">
            <h2>Update User Info</h2>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="userimg">User Photo:</label>
                    <input type="file" class="form-control" id="userimg" name="userimg" value="<?php echo $imageURL; ?>">
                </div>
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" class="form-control" id="username" name="username" value="<?php echo $updateUsername; ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo $updateUseremail; ?>" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" id="password" name="password" value="<?php echo $updateUserpassword; ?>" required>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
            <br>
        </div>
    </div>
</div>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    function test_input($value)
    {
        $value = trim($value);
        $value = stripslashes($value);
        $value = htmlspecialchars($value);
        return $value;
    }

    if (isset($_POST['username'])) {
        $userName = test_input($_POST['username']);
        $email = test_input($_POST['email']);
        $password = test_input($_POST['password']);
        $image = $_FILES['userimg'];
        $file_img = "images/" . $image['name'];
        move_uploaded_file($image['tmp_name'], $file_img);
        $userPhoto = $image['name'];
        $sql = "UPDATE users SET 
        Username='$userName',
        Email='$email',
        Password='$password',
        User_Photo='$userPhoto'
        WHERE User_Id='$user_id'";
    }

    if ($connection->query($sql) === TRUE) {
        header('Location: profile.php?Result=Updated'); 
		
    } else {
      $error= "Something went wrong: " . $sql . "<br>" . $connection->error;
		header('Location:error?Result=.$error');

    }
    $connection->close();
}
?>
</body>
</html>
