<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
$mysqli = new mysqli("sxt9335.uta.cloud", "sxt9335_skillbridge", "skillbridge@007", "sxt9335_SkillBridge");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$policyId = $_POST['policyId'];
$qaPolicies = $_POST['qaPolicies'];
$year = $_POST['year'];

// Use prepared statements to prevent SQL injection
$stmt = $mysqli->prepare("INSERT INTO qAUpdates (policyId, qaPolicies, year) VALUES (?, ?, ?)");
$stmt->bind_param("ssi", $policyId, $qaPolicies, $year);

if ($stmt->execute()) {
    // Data inserted successfully
    echo "QA added successfully";
} else {
    // Failed to insert data
    echo "Error: " . $stmt->error;
}

// Close prepared statement and database connection
$stmt->close();
$mysqli->close();
?>
