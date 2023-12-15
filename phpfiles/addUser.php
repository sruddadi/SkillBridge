<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
$mysqli = new mysqli("sxt9335.uta.cloud", "sxt9335_skillbridge", "skillbridge@007", "sxt9335_SkillBridge");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$userEmail = $_POST['userEmail'];
$password = $_POST['password'];
$role = $_POST['role'];
$stmt =  "INSERT INTO `users`(`first_name`, `last_name`, `email`, `password`,`role`) VALUES ('$first_name','$last_name','$userEmail','$password','$role')";

    if ($mysqli->query($stmt) === TRUE) {
        // User registered successfully
        echo "User added successfully";
    } else {
        // Failed to register user
        echo "Error: " . $stmt . "<br>" . $mysqli->error;
    }

// Close database connection
$mysqli->close();
?>