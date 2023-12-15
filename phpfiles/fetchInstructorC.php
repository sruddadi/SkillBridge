<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

$mysqli = new mysqli("sxt9335.uta.cloud", "sxt9335_skillbridge", "skillbridge@007", "sxt9335_SkillBridge");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$email = $_POST['email'];

$sql = "SELECT * FROM users WHERE email = '$email'";

$query = mysqli_query($mysqli, $sql);

$name = ""; // Initialize the $name variable

if ($query->num_rows > 0) {
    // Fetch the user's role from the result
    $row = $query->fetch_assoc();
    $fname = $row['first_name'];
    $lname = $row['last_name'];

    // Concatenate the role with the message
    $name = "$fname $lname";
} else {
    $name = "Failed";
}

$sqlUserCount = "SELECT COUNT(*) as userCount FROM users where role = 'Student'";
$sqlCourseCount = "SELECT COUNT(DISTINCT email) as courseCount FROM classesEnrolled WHERE status = 'yes' and professorName = '$name'";
$sqlProgramCount = "SELECT COUNT(*) as programCount FROM classesEnrolled where quizlink is not null";
$sqlSomeCount = "SELECT COUNT(*) as someCount FROM classesEnrolled where status='no' and professorName = '$name'";

$queryUserCount = mysqli_query($mysqli, $sqlUserCount);
$queryCourseCount = mysqli_query($mysqli, $sqlCourseCount);
$queryProgramCount = mysqli_query($mysqli, $sqlProgramCount);
$querySomeCount = mysqli_query($mysqli, $sqlSomeCount);

if ($queryUserCount && $queryCourseCount) {
    $rowUserCount = mysqli_fetch_assoc($queryUserCount);
    $userCount = $rowUserCount['userCount'];

    $rowCourseCount = mysqli_fetch_assoc($queryCourseCount);
    $courseCount = $rowCourseCount['courseCount'];
    
    $rowProgramCount = mysqli_fetch_assoc($queryProgramCount);
    $programCount = $rowProgramCount['programCount'];
    
    $rowSomeCount = mysqli_fetch_assoc($querySomeCount);
    $someCount = $rowSomeCount['someCount'];

    echo "$userCount,$courseCount,$programCount,$someCount"; // Return both counts in the response
} else {
    echo "Error in executing the query";
}

$mysqli->close();
?>
