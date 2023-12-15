<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
$mysqli = new mysqli("sxt9335.uta.cloud", "sxt9335_skillbridge", "skillbridge@007", "sxt9335_SkillBridge");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$program = $_POST['program'];

$stmt = $mysqli->prepare("DELETE FROM programs WHERE programName = ?");
$stmt->bind_param("s", $program);

if ($stmt->execute()) {
    echo "Program deleted successfully";
} else {
    echo "Error deleting Program: " . $mysqli->error;
}

$stmt->close();
$mysqli->close();
?>