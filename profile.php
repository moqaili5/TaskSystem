<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
 
        body {
            background-color: #EAFAF1;
        }
        .container {
            padding: 20px;
        }
        .user-card {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 20px;
            margin-bottom: 20px;
            background-color: #fff;
        }
        .Email {
            font-weight: bold;
          
        }
       .username{font-weight:bold;}
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
  <title>Profile Page</title>
</head>
<body>
<div>
    <ul>
        <li><a href="index.php">Home</a></li>
          <li><a href="notfications.php">Notfications</a></li>
		<li><a href="add_task.php">Add Task</a></li>
        <li><a href="profile.php">Profile</a></li>
        <li><a href="https://api.whatsapp.com/send/?phone=%2B970594623402&text&type=phone_number&app_absent=0" target="_blanck">Contact Us</a></li>
        <li class="page-title">TaskFlow</li>
    </ul>
</div>


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
$user_id = $_SESSION['user'];
$sql = "SELECT * FROM users WHERE User_id='$user_id'";

        $result = $connection->query($sql);
        if ($result->num_rows > 0) {
       while( $row = $result->fetch_assoc())
	   {
		$imageURL = "images/" . $row['User_Photo'];
            $username=$row['Username'];
           $email=$row['Email'];
	   }
		}
				$connection->close();

				?>
				<div class=" mt-3 bg-success">
				<p class="display-4 pl-5">Profile</p>
				</div>
			 <div class="container p-3 mt-2 user-card bg-light">
               <h3>User Photo </h3>
              <img class="img-thumbnail" src="<?php echo $imageURL;?>" alt="User Image" height="130px" width="130px";>
             <br>
			 <br>
			 <h3>User name :</h3>
            <p class="username text-success"style="font-size:20px;"><?php echo $username; ?></p>
			   <h3>Email :</h3>
             <p class='Email text-success'style="font-size:20px;"><?php echo  $email;?> </p>
             </div>
					<div class="container">
					<a href="update_user_profile.php" class="btn btn-success">Edit user profile</a>
					</div>



	    


</body>
</html>
