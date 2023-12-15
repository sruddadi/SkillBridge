<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
$mysqli = new mysqli("sxt9335.uta.cloud", "sxt9335_skillbridge", "skillbridge@007", "sxt9335_SkillBridge");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$initialprogram_id = $_POST['initialprogram_id'];
    $programName = $_POST['programName'];
    $programDescription = $_POST['programDescription'];
    $programOrganizer = $_POST['programOrganizer'];
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];

// Update user details
$stmt = "UPDATE `programs` SET programName = '$programName', programDescription = '$programDescription', programOrganizer = '$programOrganizer', startDate = '$startDate', endDate = '$endDate' WHERE programName = '$initialprogram_id'";

if ($mysqli->query($stmt) === TRUE) {
    
    echo "Program updated successfully";
} else {
    
    echo "Error: " . $stmt . "<br>" . $mysqli->error;
}

$mysqli->close();
?>