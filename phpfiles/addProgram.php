<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
$mysqli = new mysqli("sxt9335.uta.cloud", "sxt9335_skillbridge", "skillbridge@007", "sxt9335_SkillBridge");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$programName = $_POST['programName'];
$programDescription = $_POST['programDescription'];
$programOrganizer = $_POST['programOrganizer'];
$startDate = $_POST['startDate'];
$endDate = $_POST['endDate'];
$venue = $_POST['venue'];

$stmt = "INSERT INTO `programs`(`programName`, `programOrganizer`, `programDescription`, `startDate`,`endDate`,`venue`) VALUES ('$programName','$programOrganizer','$programDescription','$startDate','$endDate','$venue')";

    if ($mysqli->query($stmt) === TRUE) {
        // User registered successfully
        echo "Program added successfully";
    } else {
        // Failed to register user
        echo "Error: " . $stmt . "<br>" . $mysqli->error;
    }

// Close database connection
$mysqli->close();
?>
