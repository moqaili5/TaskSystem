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
    <title>Home page</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
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
<body style="background-color: #EAFAF1;">
<div>
    <!-- Your navigation menu remains unchanged -->
    <ul>
        <li><a href="index.php">Home</a></li>
          <li><a href="notfications.php">Notfications</a></li>
		<li><a href="add_task.php">Add Task</a></li>
        <li><a href="profile.php">Profile</a></li>
        <li><a href="https://api.whatsapp.com/send/?phone=%2B970594623402&text&type=phone_number&app_absent=0" target="_blanck">Contact Us</a></li>
        <li class="page-title">TaskFlow</li>
    </ul>
</div>
<div class="container">
    <h1>All Tasks</h1>
    <?php
    $user_id = $_SESSION['user'];
    $sql = "SELECT * FROM tasks WHERE User_id='$user_id'";
    $result = $connection->query($sql);
    if ($result->num_rows > 0) {
        echo '<form action="task_details.php" method="post" id="taskDetailsForm">';
        echo '<label for="taskSelect"><h4>Your Task Names:</h4></label>';
		echo "<br>";

        echo '<select class="form-control" id="taskSelect" name="task_id">';

        while ($row = $result->fetch_assoc()) {
            echo '<option value="' . $row["TaskName"] . '">' . $row["TaskName"] . '</option>';

        }

        echo '</select>';
		echo "<br>";
        
        echo '<button type="submit" class="btn btn-success" onclick="showTaskDetails(\'taskDetailsForm\')">To show more about this task</button>';
        echo '<button type="button" class="btn btn-warning ml-3" onclick="editTaskDetails(\'taskDetailsForm\')">Edit Task</button>';

        echo '<script>
        function editTaskDetails(formId) {
            var selectedTask = document.getElementById(formId).elements[\'task_id\'];
            var selectedTaskName = selectedTask.value;
        
            var selectedTaskId = encodeURIComponent(selectedTaskName);
        
            window.location.href = \'update_task.php?Task_Id=\' + selectedTaskId;
        }
        
    </script>';
        echo '</form>';
		echo "<br>";
		echo"<hr>";
		echo"<h2>Tasks in order of priority</h2>";
        // Form for High-Priority Tasks
        $highPrioritySql = "SELECT * FROM tasks WHERE User_id='$user_id' AND TaskPriority='High'";
        $highPriorityResult = $connection->query($highPrioritySql);
        if ($highPriorityResult->num_rows > 0) {
            echo '<form action="task_details.php" method="post" id="highPriorityForm">';
			echo "<br>";

            echo '<label for="highPriorityTaskSelect"><h4>Your High Priority Tasks:</h4></label>';
            echo '<select class="form-control" id="highPriorityTaskSelect" name="task_id">';
            while ($row = $highPriorityResult->fetch_assoc()) {
                echo '<option value="' . $row["TaskName"] . '">' . $row["TaskName"] . '</option>';
            }
            echo '</select>';
			echo "<br>";

            echo '<button type="submit" class="btn btn-success" onclick="showTaskDetails(\'highPriorityForm\')">To show more about this task</button>';
       
	   echo '<button type="button" class="btn btn-warning ml-3" onclick="editTaskDetails(\'highPriorityForm\')">Edit Task</button>';
           
		   echo '</form>';
        }
		echo "<br>";
			echo "<br>";

        // Form for Medium-Priority Tasks
        $mediumPrioritySql = "SELECT * FROM tasks WHERE User_id='$user_id' AND TaskPriority='Medium'";
        $mediumPriorityResult = $connection->query($mediumPrioritySql);
        if ($mediumPriorityResult->num_rows > 0) {
            echo '<form action="task_details.php" method="post" id="mediumPriorityForm">';
            echo '<label for="mediumPriorityTaskSelect"><h4>Your Medium Priority Tasks:</h4></label>';
            echo '<select class="form-control" id="mediumPriorityTaskSelect" name="task_id">';
            while ($row = $mediumPriorityResult->fetch_assoc()) {
                echo '<option value="' . $row["TaskName"] . '">' . $row["TaskName"] . '</option>';
            }
            echo '</select>';
			echo "<br>";

            echo '<button type="submit" class="btn btn-success" onclick="showTaskDetails(\'mediumPriorityForm\')">To show more about this task</button>';
            echo '<button type="button" class="btn btn-warning ml-3" onclick="editTaskDetails(\'mediumPriorityForm\')">Edit Task</button>';

			echo '</form>';
			echo "<br>";
			echo "<br>";
        }

        // Form for Low-Priority Tasks
        $lowPrioritySql = "SELECT * FROM tasks WHERE User_id='$user_id' AND TaskPriority='Low'";
        $lowPriorityResult = $connection->query($lowPrioritySql);
        if ($lowPriorityResult->num_rows > 0) {
            echo '<form action="task_details.php" method="post" id="lowPriorityForm">';
            echo '<label for="lowPriorityTaskSelect"><h4>Your Low Priority Tasks:</h4></label>';
            echo '<select class="form-control" id="lowPriorityTaskSelect" name="task_id">';
            while ($row = $lowPriorityResult->fetch_assoc()) {
                echo '<option value="' . $row["TaskName"] . '">' . $row["TaskName"] . '</option>';
            }
            echo '</select>';
			echo "<br>";

            echo '<button type="submit" class="btn btn-success" onclick="showTaskDetails(\'lowPriorityForm\')">To show more about this task</button>';
            echo '<button type="button" class="btn btn-warning ml-3" onclick="editTaskDetails(\'lowPriorityForm\')">Edit Task</button>';

		   echo '</form>';
			echo "<br>";
			echo "<br>";
        }
		echo"<hr>";

			echo"<h2>Tasks in order of Classification</h2>";
echo"<br>";
		/////business task 
		 $businessSql = "SELECT * FROM tasks WHERE User_id='$user_id' AND Classification='Business'";
        $businessResult = $connection->query($businessSql);
        if ($businessResult->num_rows > 0) {
            echo '<form action="task_details.php" method="post" id="bForm">';
            echo '<label for="lowPriorityTaskSelect"><h4>Your Business Tasks:</h4></label>';
            echo '<select class="form-control" id="lowPriorityTaskSelect" name="task_id">';
            while ($row = $businessResult->fetch_assoc()) {
                echo '<option value="' . $row["TaskName"] . '">' . $row["TaskName"] . '</option>';
            }
            echo '</select>';
			echo "<br>";
            echo '<button type="submit" class="btn btn-success" onclick="showTaskDetails(\'bForm\')">To show more about this task</button>';
            echo '<button type="button" class="btn btn-warning ml-3" onclick="editTaskDetails(\'lowPriorityForm\')">Edit Task</button>';

			echo '</form>';
			echo "<br>";
			echo "<br>";
        }
		
	//house task 

        $houseSql = "SELECT * FROM tasks WHERE User_id='$user_id' AND Classification='Home'";
        $houseResult = $connection->query($houseSql);
        if ($houseResult->num_rows > 0) {
            echo '<form action="task_details.php" method="post" id="hForm">';
            echo '<label for="lowPriorityTaskSelect"><h4>Your Home Tasks:</h4></label>';
            echo '<select class="form-control" id="lowPriorityTaskSelect" name="task_id">';
            while ($row = $houseResult->fetch_assoc()) {
                echo '<option value="' . $row["TaskName"] . '">' . $row["TaskName"] . '</option>';
            }
            echo '</select>';
			echo "<br>";

            echo '<button type="submit" class="btn btn-success" onclick="showTaskDetails(\'hForm\')">To show more about this task</button>';
            echo '<button type="button" class="btn btn-warning ml-3" onclick="editTaskDetails(\'lowPriorityForm\')">Edit Task</button>';

			echo '</form>';
			echo "<br>";
			echo "<br>";
        }
//personal tasks
        $personalSql = "SELECT * FROM tasks WHERE User_id='$user_id' AND Classification='Personal'";
        $personalResult = $connection->query($personalSql);
        if ($personalResult->num_rows > 0) {
			
            echo '<form action="task_details.php" method="post" id="pForm">';
            echo '<label for="lowPriorityTaskSelect"><h4>Your Personal Tasks:</h4></label>';
            echo '<select class="form-control" id="lowPriorityTaskSelect" name="task_id">';
            while ($row = $personalResult->fetch_assoc()) {
                echo '<option value="' . $row["TaskName"] . '">' . $row["TaskName"] . '</option>';
            }
            echo '</select>';
			echo "<br>";

            echo '<button type="submit" class="btn btn-success" onclick="showTaskDetails(\'pForm\')">To show more about this task</button>';
            echo '<button type="button" class="btn btn-warning ml-3" onclick="editTaskDetails(\'pForm\')">Edit Task</button>';
           
		   echo '</form>';
			echo "<br>";
			echo "<br>";
		}
		$otherSql = "SELECT * FROM tasks WHERE User_id='$user_id' AND Classification='Other'";
        $otherResult = $connection->query($otherSql);
        if ($otherResult->num_rows > 0) {
            echo '<form action="task_details.php" method="post" id="oForm">';
            echo '<label for="lowPriorityTaskSelect"><h4>Your Others Tasks:</h4></label>';
            echo '<select class="form-control" id="lowPriorityTaskSelect" name="task_id">';
            while ($row = $otherResult->fetch_assoc()) {
                echo '<option value="' . $row["TaskName"] . '">' . $row["TaskName"] . '</option>';
            }
            echo '</select>';
			echo "<br>";

            echo '<button type="submit" class="btn btn-success" onclick="showTaskDetails(\'oForm\')">To show more about this task</button>';
            echo '<button type="button" class="btn btn-warning ml-3" onclick="editTaskDetails(\'oForm\')">Edit Task</button>';

			echo '</form>';
		}
		
        // Rest of your code remains unchanged
    } else {
        echo "You don't have any tasks.";
    }
	    $connection->close();

    ?>
    <hr>

    <div class="row mt-3">
        <div class="col-md-6">
            <?php echo '<strong>' .'</strong> <a href="logout.php"> <button class="btn btn-danger">Log Out</button></a>'; ?>
        </div>
    </div>
    <hr>

</div>

<?php include 'footer.php'; ?>

<!-- Include the Bootstrap JS and jQuery scripts at the end of the body tag -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    function showTaskDetails(formId) {
        var selectedTask = document.getElementById(formId).elements['task_id'];
        var selectedTaskId = selectedTask.value;
        document.getElementById("task_id").value = selectedTaskId;
        document.forms[formId].submit();
    }
    
</script>

</body>
</html>