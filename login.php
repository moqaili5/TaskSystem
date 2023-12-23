<?php
    session_start();
    if(isset($_SESSION['logged-in'])){
        header('Location: index.php');
        exit();
    }
?>
<?php include 'header.php';?>

<!DOCTYPE html>
<html lang="en">
<head>
<style>
  body {
            background-color: #f4f4f4;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }
		</style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body style="background-color:#EAFAF1;">
    <div class="container mt-5" >
        <div class="row justify-content-center ">
            <div class="col-md-6 border " >
                <h2>Login</h2>
                        <form action="loginValidation.php" method="POST">
						<div class="form-group">
                        <label for="username">Username:</label>
                        <input type="text" class="form-control" id="username" name="login" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
					<div>	
					<a class="btn btn-success" href="forgot_password.php">Forgot password</a>
					<button type="submit" class="btn btn-success">Login</button>
	                    <h6>I dont have account</h6>
						<a class="btn btn-success" href="register.php">Register</a>

                    </div>
					
                </form>
			
                <?php
            if(isset($_SESSION['loginError'])){
                $error= $_SESSION['loginError'];
				header('Location:error?Result=.$error');

            }
        ?>
            </div>
        </div>
    </div>

</body>
</html>