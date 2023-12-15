<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

$conn = new mysqli("sxt9335.uta.cloud", "sxt9335_skillbridge", "skillbridge@007", "sxt9335_SkillBridge");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$data = array();

// Fetch course names and their associated student counts
$coursesQuery = "SELECT courseName, COUNT(email) AS students_count FROM classesEnrolled WHERE status = 'yes' GROUP BY courseName";
$coursesResult = $conn->query($coursesQuery);

if ($coursesResult->num_rows > 0) {
    while ($row = $coursesResult->fetch_assoc()) {
        $data["labels"][] = $row["courseName"];
        $data["datasets"][0]["data"][] = $row["students_count"];
    }
}

// Close the database connection
$conn->close();

// Send the data as JSON
header("Content-Type: application/json");
echo json_encode($data);
?>
