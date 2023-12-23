<?php
session_start();
if (!isset($_SESSION['logged-in'])) {
    header('Location: login.php');
    exit();
}

require_once "connect.php"; // Include your database connection code

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
    <title>Task Details</title>
    <!-- Include Bootstrap CSS -->
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
<body style="background-color: #EAFAF1;">
<div>
    <!-- Your navigation menu remains unchanged -->
    <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="add_task.php">Add Task</a></li>
        <li><a href="#services">Services</a></li>
        <li><a href="#portfolio">Profile</a></li>
        <li><a href="#contact">Contact</a></li>
        <li class="page-title">TaskFlow</li>
    </ul>
</div>

<div class="container">
    <h1 class="text-center">Task Details</h1>
    <?php
    if (isset($_POST['task_id'])) {
        $task_id = $_POST['task_id'];
        $user_id = $_SESSION['user'];
        $sql = "SELECT * FROM tasks WHERE User_id='$user_id' && TaskName='$task_id' ";
        $result = $connection->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="task-card">';
                echo '<h3>Task Name</h3>';
                echo '<p>' . $row["TaskName"] . '</p>';
                echo '<h3>Task Date</h3>';
                echo '<p>' . $row["TaskDate"] . '</p>';
                echo '<h3>Task Priority</h3>';
                echo '<p class="task-priority">' . $row["TaskPriority"] . '</p>';
                echo '<h3>Task Classification</h3>';
                echo '<p class="task-classification">' . $row["Classification"] . '</p>';
                echo '<h3>Task Description</h3>';
                echo '<p>' . $row["TaskDescription"] . '</p>';
                echo '</div>';
            }
        } else {
            echo "Task details not found.";
        }
    } else {
        $error="Task ID is not set.";//error page
		header('Location:error?Result='.$error);

    }
    ?>
    <!-- Add the delete button -->
<form action="delete_task.php" method="post" id="deleteTaskForm">
    <input type="hidden" name="task_id" value="<?php echo isset($_POST['task_id']) ? $_POST['task_id'] : ''; ?>">
    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this task?')">Delete Task</button>
</form>

</div>

<!-- Include Bootstrap JS and jQuery scripts at the end of the body tag -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
