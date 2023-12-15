<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

$mysqli = new mysqli("sxt9335.uta.cloud", "sxt9335_skillbridge", "skillbridge@007", "sxt9335_SkillBridge");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$sqlUserCount = "SELECT COUNT(*) as userCount FROM users where role = 'Student'";
$sqlCourseCount = "SELECT COUNT(*) as courseCount FROM programs";
$sqlProgramCount = "SELECT COUNT(*) as programCount FROM programEnroll";

$queryUserCount = mysqli_query($mysqli, $sqlUserCount);
$queryCourseCount = mysqli_query($mysqli, $sqlCourseCount);
$queryProgramCount = mysqli_query($mysqli, $sqlProgramCount);

if ($queryUserCount && $queryCourseCount) {
    $rowUserCount = mysqli_fetch_assoc($queryUserCount);
    $userCount = $rowUserCount['userCount'];

    $rowCourseCount = mysqli_fetch_assoc($queryCourseCount);
    $courseCount = $rowCourseCount['courseCount'];
    
    $rowProgramCount = mysqli_fetch_assoc($queryProgramCount);
    $programCount = $rowProgramCount['programCount'];

    echo "$userCount,$courseCount,$programCount"; // Return both counts in the response
} else {
    echo "Error in executing the query";
}

$mysqli->close();
?>
