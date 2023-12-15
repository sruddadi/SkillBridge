<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST");
header("Access-Control-Allow-Headers: X-Requested-With");

$conn = new mysqli("sxt9335.uta.cloud", "sxt9335_skillbridge", "skillbridge@007", "sxt9335_SkillBridge");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// $sql = "SELECT role, COUNT(*) as count FROM Users GROUP BY role";
$sql = "SELECT COUNT(*) as countR, role FROM users GROUP BY role";

$result = $conn->query($sql);

$conn->close();
?>
