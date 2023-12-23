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

// Check if task_id is provided in the URL
if (isset($_GET['Task_Id'])) {
    // Use the task name directly as Task_Id
    $task_id = $_GET['Task_Id'];

    // Check if the update form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get updated values from the form
        $updatedTaskName = $_POST['updatedTaskName'];
        $updatedTaskDate = $_POST['updatedTaskDate'];
        $updatedTaskPriority = $_POST['updatedTaskPriority'];
        $updatedTaskClassification = $_POST['updatedTaskClassification'];
        $updatedTaskDescription = $_POST['updatedTaskDescription'];

        // Add your update logic based on task_id
        // Replace the following placeholder code with your actual update code

        $updateSql = "UPDATE tasks SET 
            TaskName = '$updatedTaskName', 
            TaskDate = '$updatedTaskDate', 
            TaskPriority = '$updatedTaskPriority', 
            Classification = '$updatedTaskClassification', 
            TaskDescription = '$updatedTaskDescription' 
            WHERE TaskName = '$task_id'";

        if ($connection->query($updateSql) === TRUE) {
            echo "Task updated successfully";
        } else {
            echo "Error updating task: " . $connection->error;
        }
    }

    // Retrieve existing task details for pre-filling the form
    $selectSql = "SELECT * FROM tasks WHERE TaskName = '$task_id'";
    $result = $connection->query($selectSql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Pre-fill form fields with existing task details
        $existingTaskName = $row['TaskName'];
        $existingTaskDate = $row['TaskDate'];
        $existingTaskPriority = $row['TaskPriority'];
        $existingTaskClassification = $row['Classification'];
        $existingTaskDescription = $row['TaskDescription'];
    } else {
        echo "Task not found.";
        exit();
    }
    $connection->close();

} else {
    echo "Task ID not provided.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	 <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <title>Update Task</title>
    <!-- Add your CSS styles or include Bootstrap if needed -->
</head>
<body style="background-color:#EAFAF1;">
    <!-- Add your HTML content for the update_task.php page -->
     <div class="container">
        <h2>Update task</h2>

    <!-- Form for updating task details -->
    <form method="post">
	 <div class="form-group">
        <label for="updatedTaskName">Task Name:</label>
        <input type="text" class="form-control" name="updatedTaskName" value="<?php echo $existingTaskName; ?>" required>
</div>       
	   <br>
  <div class="form-group">
        <label for="updatedTaskDate">Task Date:</label>
        <input type="date" class="form-control" name="updatedTaskDate" value="<?php echo $existingTaskDate; ?>" required>
        </div>
		<br>
  <div class="form-group">
        <label for="updatedTaskPriority">Task Priority:</label>
        <select name="updatedTaskPriority" class="form-control"  required>
            <option value="High" <?php if ($existingTaskPriority === 'High') echo 'selected'; ?>>High</option>
            <option value="Medium" <?php if ($existingTaskPriority === 'Medium') echo 'selected'; ?>>Medium</option>
            <option value="Low" <?php if ($existingTaskPriority === 'Low') echo 'selected'; ?>>Low</option>
        </select>
        </div>
		<br>
  <div class="form-group">

        <label for="updatedTaskClassification">Task Classification:</label>
        <select name="updatedTaskClassification" class="form-control" required>
            <option value="Business" <?php if ($existingTaskClassification === 'Business') echo 'selected'; ?>>Business</option>
            <option value="House" <?php if ($existingTaskClassification === 'House') echo 'selected'; ?>>House</option>
            <option value="Personal" <?php if ($existingTaskClassification === 'Personal') echo 'selected'; ?>>Personal</option>
        </select>
		</div>
        <br>
  <div class="form-group">

        <label for="updatedTaskDescription">Task Description:</label>
        <textarea name="updatedTaskDescription" class="form-control" required><?php echo $existingTaskDescription; ?></textarea>
        </div>
		<br>

        <button type="submit" class="btn btn-primary">Update Task</button>
    </form>
<br>	
<br>	
			<a href="index.php" class="btn btn-success">Back to home page</a>

</div>
    <!-- Include the Bootstrap JS and jQuery scripts at the end of the body tag if needed -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
