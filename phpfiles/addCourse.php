<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
$mysqli = new mysqli("sxt9335.uta.cloud", "sxt9335_skillbridge", "skillbridge@007", "sxt9335_SkillBridge");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$course_name = isset($_POST['course_name']) ? $_POST['course_name'] : '';
$course_id = isset($_POST['course_id']) ? $_POST['course_id'] : '';
$instructor_name = isset($_POST['instructor_name']) ? $_POST['instructor_name'] : '';
$course_period = isset($_POST['course_period']) ? $_POST['course_period'] : '';
$status = "no";

if (!empty($course_name) && !empty($course_id) && !empty($instructor_name) && !empty($course_period)) {
    $stmt = $mysqli->prepare("INSERT INTO classesEnrolled (courseName, courseId, professorName, period, status) VALUES (?, ?, ?, ?, ?)");

    if ($stmt) {
        $stmt->bind_param("sssss", $course_name, $course_id, $instructor_name, $course_period, $status);

        if ($stmt->execute()) {
            echo "Course added successfully";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error preparing the statement";
    }
} else {
    echo "Missing required input data";
}

// Close database connection
$mysqli->close();
?>
