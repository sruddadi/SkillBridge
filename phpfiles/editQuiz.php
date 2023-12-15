<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
$mysqli = new mysqli("sxt9335.uta.cloud", "sxt9335_skillbridge", "skillbridge@007", "sxt9335_SkillBridge");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$intialEmail_id = $_POST['intialEmail_id'];
    $startTime = $_POST['startTime'];
    $endTime = $_POST['endTime'];
    $quizlink = $_POST['quizlink'];
    $exam = $_POST['exam'];
   

// Update user details
$stmt = "UPDATE `classesEnrolled` SET startTime = '$startTime',exam = '$exam', endTime = '$endTime', quizlink = '$quizlink' WHERE email = '$intialEmail_id'";

if ($mysqli->query($stmt) === TRUE) {
    
    echo "Exam updated successfully";
} else {
    
    echo "Error: " . $stmt . "<br>" . $mysqli->error;
}

$mysqli->close();
?>