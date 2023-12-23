<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Task Notifications</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <style>
        .notification {
            margin: 10px;
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
    <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="notfications.php">Notifications</a></li>
        <li><a href="add_task.php">Add Task</a></li>
        <li><a href="profile.php">Profile</a></li>
        <li><a href="https://api.whatsapp.com/send/?phone=%2B970594623402&text&type=phone_number&app_absent=0" target="_blank">Contact Us</a></li>
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
require_once "mail.php";

// Create a new instance of PHPMailer
$mail = new PHPMailer\PHPMailer\PHPMailer();

$connection = new mysqli($host, $db_user, $db_password, $db_name);

if ($connection->connect_errno != 0) {
    echo "Error: " . $connection->connect_errno . "<br>";
    echo "Description: " . $connection->connect_error;
    exit();
}

$user_Id = $_SESSION['user'];
$sql = "SELECT * FROM tasks WHERE User_id='$user_Id'";
$dateResult = $connection->query($sql);

if ($dateResult->num_rows > 0) {
    echo "<div class='container border'> <h1 class='display-4'>Notifications  <span class='fas fa-bell'></span></h1>  </div>";
    echo "<br>";
    while ($row = $dateResult->fetch_assoc()) {
        echo "<br>";
        
        $taskId = $row['Task_Id'];
        $datedata = $row['TaskDate'];
        $todaydate = date("Y-m-d");

        $daysleft = floor((strtotime($datedata) - strtotime($todaydate)) / (60 * 60 * 24));
        $emailResult = $connection->query("SELECT * FROM users WHERE User_id='$user_Id'");

        echo "<div class='container border' style='background-color:#82E0AA;'>";
        if ($emailResult->num_rows > 0) {
            $rowUser = $emailResult->fetch_assoc();
            $email = $rowUser['Email'];
        
            $mail->setFrom('taskflow868@gmail.com', 'TaskFlow');
            $mail->addAddress($email);
            $mail->Subject = 'Alert';
        
            // Check if "TaskName" key exists in $row array
            if (isset($row['TaskName'])) {
                $mail->Body = "The task " . $row['TaskName'] . " have " . $daysleft . " days.";
            } else {
                echo 'Error: TaskName key not found in the $row array.';
                exit();
            }
        
            // Send the email
            if ($mail->send()) {
                echo 'Email sent successfully!';
            } else {
                echo 'Error sending email: ' . $mail->ErrorInfo;
            }
        }
        

        if ($daysleft >= 0) {
            echo "<div class='notification'>";
            echo "<div class='alert alert-success'>";
            echo "<strong>The task " . $row['TaskName'] . " have " . $daysleft . " days.</strong>";
            echo " </div>";
            echo " </div>";
        }

        if ($daysleft < 0) {
            echo "<div class='notification'>";
            echo "<div class='alert alert-danger'>";
            echo "<strong>The task " . $row['TaskName'] . " have " . $daysleft . " days.</strong><span><strong class='float-right'>Missed</strong></span>";
            echo " </div>";
            echo " </div>";
        }

        echo "</div>";

    }
}
?>

</body>
</html>
