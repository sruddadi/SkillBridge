<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST");
header("Access-Control-Allow-Headers: X-Requested-With");

$conn = new mysqli("sxt9335.uta.cloud", "sxt9335_skillbridge", "skillbridge@007", "sxt9335_SkillBridge");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM programs";
$mysql = mysqli_query($conn, $sql);
if ($mysql->num_rows > 0) {
    // Fetch the data and store it in an array
    $programs = array();

    while ($row = $mysql->fetch_assoc()) {
        $programs[] = $row;
    }
    echo json_encode(['AllPrograms' => $programs]);
} else {
    echo json_encode(array());
}

$conn->close();
?>
