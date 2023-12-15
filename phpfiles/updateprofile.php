<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
$mysqli = new mysqli("sxt9335.uta.cloud", "sxt9335_skillbridge", "skillbridge@007", "sxt9335_SkillBridge");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$email = $_POST['email'];
$password = $_POST['password'];

// Update user details
$stmt = "UPDATE `users` SET first_name = '$firstname', last_name = '$lastname', password = '$password' WHERE email = '$email'";

if ($mysqli->query($stmt) === TRUE) {
    // Details updated successfully, now fetch the user's role
    $roleQuery = "SELECT role FROM `users` WHERE email = '$email'";
    $result = $mysqli->query($roleQuery);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $userRole = $row['role'];

        echo "Login Successful | Role: $userRole";
    } else {
        echo "Details updated successfully. User role not found.";
    }
} else {
    // Failed to update user details
    echo "Error: " . $stmt . "<br>" . $mysqli->error;
}

// Close database connection
$mysqli->close();
?>
