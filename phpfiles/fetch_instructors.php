<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$mysqli = new mysqli("sxt9335.uta.cloud", "sxt9335_skillbridge", "skillbridge@007", "sxt9335_SkillBridge");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Fetch instructor names from the database
$sql = "SELECT first_name FROM users WHERE role = 'Instructor'";
$result = mysqli_query($mysqli, $sql);

// Check for errors
if (!$result) {
    die("Error: " . mysqli_error($mysqli));
}

// Fetch and store instructor names
$instructors = array();
while ($row = mysqli_fetch_assoc($result)) {
    $instructors[] = $row['first_name'];
}

// Return instructor names as JSON
echo json_encode($instructors);

// Close the database connection
mysqli_close($mysqli);
?>
