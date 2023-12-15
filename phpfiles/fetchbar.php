<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

$mysqli = new mysqli("sxt9335.uta.cloud", "sxt9335_skillbridge", "skillbridge@007", "sxt9335_SkillBridge");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$sqlUserCount = "SELECT COUNT(*) as admin FROM users where role = 'Admin'";
$sqlCourseCount = "SELECT COUNT(*) as students FROM users where role = 'Student'";
$sqlProgramCount = "SELECT COUNT(*) as instructors FROM users where role = 'Instructor'";
$sqlPcCount = "SELECT COUNT(*) as pc FROM users where role = 'Program Coordinator'";
$sqlQACount = "SELECT COUNT(*) as qa FROM users where role = 'QA Officer'";

$queryUserCount = mysqli_query($mysqli, $sqlUserCount);
$queryCourseCount = mysqli_query($mysqli, $sqlCourseCount);
$queryProgramCount = mysqli_query($mysqli, $sqlProgramCount);
$queryPcCount = mysqli_query($mysqli, $sqlPcCount);
$queryQACount = mysqli_query($mysqli, $sqlQACount);

if ($queryUserCount && $queryCourseCount) {
    $rowUserCount = mysqli_fetch_assoc($queryUserCount);
    $userCount = $rowUserCount['admin'];

    $rowCourseCount = mysqli_fetch_assoc($queryCourseCount);
    $courseCount = $rowCourseCount['students'];
    
    $rowProgramCount = mysqli_fetch_assoc($queryProgramCount);
    $programCount = $rowProgramCount['instructors'];
    
    $rowPcCount = mysqli_fetch_assoc($queryPcCount);
    $pcCount = $rowPcCount['pc'];
    
    $rowQACount = mysqli_fetch_assoc($queryQACount);
    $qaCount = $rowQACount['qa'];

    echo "$userCount,$courseCount,$programCount,$pcCount,$qaCount"; // Return both counts in the response
} else {
    echo "Error in executing the query";
}

$mysqli->close();
?>
