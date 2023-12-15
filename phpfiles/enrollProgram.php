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
    $s = $_POST['s'];
    $ss = $_POST['ss'];

// Update user details
$stmt = "INSERT INTO `programEnroll`(`sname`, `semail`, `programName`, `pOrganizer`,`pDescription`,`startDate`,`endDate`,`venue`) VALUES ('$name','$email','$course_id','$courseName','$instructorName','$coursePeriod','$s','$ss')";

if ($mysqli->query($stmt) === TRUE) {
    
    echo "Course enrolled successfully";
} else {
    
    echo "Error: " . $stmt . "<br>" . $mysqli->error;
}

$mysqli->close();
?>
