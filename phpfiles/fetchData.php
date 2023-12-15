<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$mysqli = new mysqli("sxt9335.uta.cloud", "sxt9335_skillbridge", "skillbridge@007", "sxt9335_SkillBridge");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$query = "SELECT role, COUNT(*) as userCount FROM users GROUP BY role";
$result = $mysqli->query($query);

$data = array();

while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

$mysqli->close();

echo json_encode($data);
?>
