<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
$mysqli = new mysqli("sxt9335.uta.cloud", "sxt9335_skillbridge", "skillbridge@007", "sxt9335_SkillBridge");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
$courseId = $_POST['courseId'];

$sql = "SELECT * FROM programs WHERE programName = '$courseId'";

$query = mysqli_query($mysqli, $sql);

if ($query->num_rows > 0) {
    // Fetch the user's role from the result
    $row = $query->fetch_assoc();
    $courseName = $row['programOrganizer'];
    $professorName = $row['programDescription'];
    $period = $row['startDate'];
    $s = $row['endDate'];
    $ss = $row['venue'];

    // Concatenate the role with the message
    echo "$courseName,$professorName,$period,$s,$ss";
} else {
    echo "Error: " . $sql . "<br>" . $mysqli->error;
}


$mysqli->close();
?>