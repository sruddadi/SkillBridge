


<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
$mysqli = new mysqli("sxt9335.uta.cloud", "sxt9335_skillbridge", "skillbridge@007", "sxt9335_SkillBridge");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$intialpolicyId = $_POST['intialpolicyId'];
    $qaPolicies = $_POST['qaPolicies'];
    $year = $_POST['year'];
    
// Update user details
$stmt = "UPDATE `qAUpdates` SET qaPolicies = '$qaPolicies',year = '$year' WHERE policyId = '$intialpolicyId'";
if ($mysqli->query($stmt) === TRUE) {
    
    echo "QA updated successfully";
} else {
    
    echo "Error: " . $stmt . "<br>" . $mysqli->error;
}

$mysqli->close();
?>