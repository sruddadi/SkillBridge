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
$role = $_POST['role'];

$sql1 = "SELECT * FROM users where email='$email'";
$query = mysqli_query($mysqli, $sql1);
if ($query->num_rows == 0) {

    $stmt = "INSERT INTO `users`(`first_name`, `last_name`, `email`, `password`,`role`) VALUES ('$firstname','$lastname','$email','$password','$role')";

    if ($mysqli->query($stmt) === TRUE) {
        // User registered successfully
        echo "User registered successfully";
    } else {
        // Failed to register user
        echo "Failed to register user";
    }
} else {
    echo "User already exists";
}

// Close database connection
$mysqli->close();

?>