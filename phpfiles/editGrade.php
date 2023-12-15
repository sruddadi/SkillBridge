
<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
$mysqli = new mysqli("sxt9335.uta.cloud", "sxt9335_skillbridge", "skillbridge@007", "sxt9335_SkillBridge");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$intialEmail_id = $_POST['intialEmail_id'];
    $grade = $_POST['grade'];
    $courseId = $_POST['courseId'];
    $resources = $_POST['resources'];
   
   

// Update user details
$stmt = "UPDATE `classesEnrolled` SET resources = '$resources', grade = '$grade' WHERE email = '$intialEmail_id' and courseId = '$courseId'";

if ($mysqli->query($stmt) === TRUE) {
    
    echo "Grade updated successfully";
} else {
    
    echo "Error: " . $stmt . "<br>" . $mysqli->error;
}

$mysqli->close();
?>