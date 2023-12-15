<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
$mysqli = new mysqli("sxt9335.uta.cloud", "sxt9335_skillbridge", "skillbridge@007", "sxt9335_SkillBridge");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}


$exam = $_POST['exam'];
    $startTime = $_POST['startTime'];
    $endTime = $_POST['endTime'];
    $quizlink = $_POST['quizlink'];
    $resources = $_POST['resources'];
    $courseId = $_POST['courseId'];
    

// Update user details
$stmt = "UPDATE `classesEnrolled` SET exam = '$exam', startTime = '$startTime', endTime = '$endTime', quizlink = '$quizlink', resources = '$resources' where courseId = '$courseId' and status = 'yes'";

if ($mysqli->query($stmt) === TRUE) {
    
    echo "Exam added successfully";
} else {
    
    echo "Error: " . $stmt . "<br>" . $mysqli->error;
}

$mysqli->close();
?>