<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Page</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Your existing styles remain unchanged */
        body {
            background-color: #f8f9fa;
        }
        .container {
            padding: 20px;
        }
        .task-card {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 20px;
            margin-bottom: 20px;
            background-color: #fff;
        }
        .task-priority {
            font-weight: bold;
            color: #dc3545;
        }
        .task-classification {
            font-weight: bold;
            color: #007bff;
        }
        ul {
            list-style-type: none;
            background-color: #229954;
            overflow: hidden;
            margin: 0;
            padding: 0;
        }
        li {
            float: left;
        }
        li a {
            color: white;
            text-decoration: none;
            text-align: center;
            padding: 10px;
            display: block;
        }
        li a:hover {
            background-color: #D5F5E3;
        }
        .page-title {
            float: right;
            padding: 14px 80px;
            color: white;
            font-family: Copperplate Gothic Bold;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 border">
                <h2>Register</h2>
                <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
				<div class="form-group">
                        <label for="userimg">User photo :</label>
                        <input type="file" class="form-control" id="userimg" name="userimg" >
                    </div>
                    <div class="form-group">
                        <label for="username">Username :</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email :</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password :</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Register</button>
					<br>
					<br>
                </form>
            </div>
        </div>
    </div>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
	function test_input($value)
{
$value=trim($value);
$value=stripslashes($value);
$value=htmlspecialchars($value);
return $value;	
}

	  if (isset($_POST['username'])) {
$userName=test_input($_POST['username']);
$email=test_input($_POST['email']);
$password=test_input($_POST['password']);
$image=$_FILES['userimg'];
$fil_img="images/".$image['name'];
move_uploaded_file($image['tmp_name'],$fil_img);
$userPhoto=$image['name'];
$checkempty="0";
if(empty($userName))
{
	
	$checkempty="Refill yourname";
}
else if(empty($email))
{
	$checkempty="Refill your Email";

}
else if(empty($password))
{
		$checkempty="Refill your password";

}
}
else
{
echo"Refill all requiemants";	
}	

if($checkempty=="0")
{
$servername="localhost";
$username="root";
$passwoard="";
$dbName="taskmanagmentsystem";

$conn=new mysqli($servername,$username,$passwoard,$dbName);
if($conn->connect_error)
{
	die("Database Connection have an error".$conn->connect_error);
}

else
{
$sql="INSERT INTO users (Username,Email,Password,User_Photo)
	VALUES('$userName','$email','$password','$userPhoto')";
}
if($conn->query($sql)===TRUE)
{	header('Location:login?Result='.$Done);

}
else
{
				  $error= "Something wrong :".$sql."<br>".$conn->error;
header('Location:error?Result=.$error');
}
$conn->close();

}
else
{
	echo"Something wrong";
}

}

?>

</body>
</html>