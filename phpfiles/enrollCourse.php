<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
$mysqli = new mysqli("sxt9335.uta.cloud", "sxt9335_skillbridge", "skillbridge@007", "sxt9335_SkillBridge");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

    $course_id = $_POST['course_id'];
    $email = $_POST['email'];
    $name = $_POST['name'];
    $courseName = $_POST['courseName'];
    $instructorName = $_POST['instructorName'];
    $coursePeriod = $_POST['coursePeriod'];

// Update user details
$stmt = "INSERT INTO `classesEnrolled`(`courseId`, `email`, `studentName`, `courseName`,`professorName`,`period`,`status`,`resources`,`grade`) VALUES ('$course_id','$email','$name','$courseName','$instructorName','$coursePeriod','yes','TBA','TBA')";

if ($mysqli->query($stmt) === TRUE) {
    
    echo "Course enrolled successfully";
} else {
    
    echo "Error: " . $stmt . "<br>" . $mysqli->error;
}

$mysqli->close();
?>
