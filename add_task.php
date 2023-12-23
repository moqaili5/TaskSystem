<?php
    session_start();
    if(!(isset($_SESSION['logged-in']))){
        header('Location: login.php');
        exit();
		}
 require_once "connect.php";

    $connection = new mysqli($host, $db_user, $db_password, $db_name);

    if($connection->connect_errno!=0){
        echo "Error: ".$connection->connect_errno . "<br>";
        echo "Description: " . $connection->connect_error;
        exit();
    }
	$user_id=$_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="en">
<head style="background-color:#EAFAF1;">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add task</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body style="background-color:#EAFAF1;">
    <div class="container">
        <h2>Add a New Task</h2>
        <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
            <div class="form-group">
                <label for="task_name">Task Name:</label>
				
				
                <input type="text" class="form-control" name="task_name" required>
            </div>
            <div class="form-group">
                <label for="task_date">Task Date:</label>
                <input type="date" class="form-control" name="task_date" required>
            </div>
            <div class="form-group">
                <label for="classification">Classification:</label>
                <select class="form-control" name="classification" required>
                    <option value="Business">Business</option>
                    <option value="House">House</option>
                    <option value="Personal">Personal</option>
					 <option value="Other">Other</option>

                </select>
            </div>
            <div class="form-group">
                <label for="priority">Priority:</label>
				 <select class="form-control" name="priority" required>
                    <option value="High">High priority</option>
                    <option value="Medium">Medium priority</option>
                    <option value="Low">Low priority</option>
                </select>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea class="form-control" name="description"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Add Task</button>
        </form>
		<br>
		<br>
		<a href="index.php" class="btn btn-success">Back to home page</a>

    </div>
	
<?php
	if($_SERVER["REQUEST_METHOD"]=="POST")
	{
function test_input($value)
{
$value=trim($value);
$value=stripslashes($value);
$value=htmlspecialchars($value);
return $value;	
}
$taskName= test_input($_POST['task_name']);
$taskDate=test_input($_POST['task_date']);
$taskClassification=test_input($_POST['classification']);	
$taskPriority=test_input($_POST['priority']);
$taskDescription=test_input($_POST['description']);
	
	
$servername="localhost";
$username="root";
$passwoard="";
$dbName="taskmanagmentsystem";
	
	$conn=new mysqli($servername,$username,$passwoard,$dbName);
	
	if($conn->connect_error)
	{
		die("Connection Failed".$conn->connect_error);
	}
	else
	{
		$sql="INSERT INTO tasks (TaskName,TaskDate,Classification,TaskPriority,TaskDescription,User_id)
		VALUES('$taskName','$taskDate','$taskClassification','$taskPriority','$taskDescription','$user_id')";
		
		if($conn->query($sql)===TRUE)
		{
			$done="The task added successfully";
			header('Location:index?Result=.$done');
		}
		else
		{
		  $error= "Something wrong :".$sql."<br>".$conn->error;
		  header('Location:error?Result=.$error');

		}
		
	}
	$conn->close();

	}
?>
	
</body>
</html>
