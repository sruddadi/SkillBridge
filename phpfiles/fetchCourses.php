<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
$mysqli = new mysqli("sxt9335.uta.cloud", "sxt9335_skillbridge", "skillbridge@007", "sxt9335_SkillBridge");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
$courseId = $_POST['courseId'];

$sql = "SELECT * FROM classesEnrolled WHERE courseId = '$courseId'";

$query = mysqli_query($mysqli, $sql);

if ($query->num_rows > 0) {
    // Fetch the user's role from the result
    $row = $query->fetch_assoc();
    $courseName = $row['courseName'];
    $professorName = $row['professorName'];
    $period = $row['period'];

    // Concatenate the role with the message
    echo "$courseName,$professorName,$period";
} else {
    echo "Error: " . $sql . "<br>" . $mysqli->error;
}


$mysqli->close();
?>