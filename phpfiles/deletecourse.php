<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
$mysqli = new mysqli("sxt9335.uta.cloud", "sxt9335_skillbridge", "skillbridge@007", "sxt9335_SkillBridge");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$course = $_POST['course'];

$stmt = $mysqli->prepare("DELETE FROM classesEnrolled WHERE courseId = ?");
$stmt->bind_param("s", $course);

if ($stmt->execute()) {
    echo "Course deleted successfully";
} else {
    echo "Error deleting course: " . $mysqli->error;
}

$stmt->close();
$mysqli->close();
?>
