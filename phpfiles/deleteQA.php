
text/x-generic deletecourse.php ( PHP script, ASCII text )
<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
$mysqli = new mysqli("sxt9335.uta.cloud", "sxt9335_skillbridge", "skillbridge@007", "sxt9335_SkillBridge");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$policyId = $_POST['policyId'];

$stmt = $mysqli->prepare("DELETE FROM qAUpdates WHERE policyId = ?");
$stmt->bind_param("s", $policyId);

if ($stmt->execute()) {
    echo "QA deleted successfully";
} else {
    echo "Error deleting course: " . $mysqli->error;
}

$stmt->close();
$mysqli->close();
?>