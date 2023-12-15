<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
$mysqli = new mysqli("sxt9335.uta.cloud", "sxt9335_skillbridge", "skillbridge@007", "sxt9335_SkillBridge");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$email = $_POST['email'];

$stmt = $mysqli->prepare("DELETE FROM users WHERE email = ?");
$stmt->bind_param("s", $email);

if ($stmt->execute()) {
    echo "User deleted successfully";
} else {
    echo "Error deleting Program: " . $mysqli->error;
}

$stmt->close();
$mysqli->close();
?>