<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
$mysqli = new mysqli("sxt9335.uta.cloud", "sxt9335_skillbridge", "skillbridge@007", "sxt9335_SkillBridge");


if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// SQL query to fetch all data from the "courses" table
$sql = "SELECT * FROM Courses";

$query = mysqli_query($mysqli, $sql);

if ($query->num_rows > 0) {
    // Fetch the data and store it in an array
    $courses = array();

    while ($row = $query->fetch_assoc()) {
        $courses[] = $row;
    }

    // Convert the array to JSON and echo the result
    echo json_encode($courses);
} else {
    // No records found
    echo json_encode(array());
}


// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     $data = json_decode(file_get_contents("php://input"));

//     $course_id = $data->course_id;
//     $course_name = $data->course_name;

//     // Implement SQL update query to update the course_name
//     $sql = "UPDATE courses SET course_name = ? WHERE course_id = ?";
    
//     $stmt = $mysqli->prepare($sql);
//     $stmt->bind_param("si", $course_name, $course_id);

//     if ($stmt->execute()) {
//         echo json_encode(["success" => true]);
//     } else {
//         echo json_encode(["success" => false]);
//     }

//     $stmt->close();
// } else {
//     echo json_encode(["success" => false, "message" => "Invalid Request"]);
// }

// Close the database connection
$mysqli->close();
?>
