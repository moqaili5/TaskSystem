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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user'];
    $task_name = $_POST['task_id']; 

    $deleteSql = "DELETE FROM tasks WHERE User_id='$user_id' AND TaskName='$task_name'";
    if ($connection->query($deleteSql) === TRUE) {
        echo "Task deleted successfully";
    } else {
        echo "Error deleting task: " . $connection->error;
    }
}

$connection->close();
?>
