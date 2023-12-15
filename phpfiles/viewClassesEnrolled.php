<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
$mysqli = new mysqli("sxt9335.uta.cloud", "sxt9335_skillbridge", "skillbridge@007", "sxt9335_SkillBridge");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

if (isset($_POST['email'])) {
    $email = $_POST['email'];

    // Use prepared statement to prevent SQL injection
    // $sql = "SELECT studentName, email, courseName, courseId, professorName FROM classesEnrolled WHERE email = ?";
    $sql = "SELECT * FROM classesEnrolled WHERE email = ?";
    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        $classes = array(); // Initialize an array to store the classes data

        while ($row = $result->fetch_assoc()) {
            $classes[] = $row; // Append each row to the classes array
        }

        if (!empty($classes)) {
            // Return the classes data as a JSON response
            $response = array(
                'success' => true,
                'classes' => $classes
            );
            echo json_encode($response);
        } else {
            // No matching records found
            $response = array(
                'success' => false,
                'message' => 'No matching records found'
            );
            echo json_encode($response);
        }
    } else {
        // Query preparation failed
        $response = array(
            'success' => false,
            'message' => 'Query preparation failed'
        );
        echo json_encode($response);
    }
} else {
    // Email not provided
    $response = array(
        'success' => false,
        'message' => 'Email not provided'
    );
    echo json_encode($response);
}

$mysqli->close();
?>
