<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
$mysqli = new mysqli("sxt9335.uta.cloud", "sxt9335_skillbridge", "skillbridge@007", "sxt9335_SkillBridge");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
$email = $_POST['email'];

$sql = "SELECT * FROM users WHERE email = '$email'";

$query = mysqli_query($mysqli, $sql);

if ($query->num_rows > 0) {
    // Fetch the user's role from the result
    $row = $query->fetch_assoc();
    $role = $row['role'];

    // Concatenate the role with the message
    echo "$role";
} else {
    echo "Login Failed";
}


$mysqli->close();
?>