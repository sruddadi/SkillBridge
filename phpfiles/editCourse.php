<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
$mysqli = new mysqli("sxt9335.uta.cloud", "sxt9335_skillbridge", "skillbridge@007", "sxt9335_SkillBridge");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$initialcourse_id = $_POST['initialcourse_id'];
    $course_id = $_POST['course_id'];
    $course_name = $_POST['course_name'];
    $instructor_name = $_POST['instructor_name'];
    $course_period = $_POST['course_period'];

// Update user details
$stmt = "UPDATE `classesEnrolled` SET courseName = '$course_name', courseId = '$course_id', professorName = '$instructor_name', period = '$course_period' WHERE courseId = '$initialcourse_id'";

if ($mysqli->query($stmt) === TRUE) {
    
    echo "Course updated successfully";
} else {
    
    echo "Error: " . $stmt . "<br>" . $mysqli->error;
}

$mysqli->close();
?>
