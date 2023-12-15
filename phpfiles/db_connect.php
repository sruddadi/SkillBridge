<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
$con  = new mysqli("sxt9335.uta.cloud", "sxt9335_skillbridge", "skillbridge@007", "sxt9335_SkillBridge");

mysqli_select_db($con,"sxt9335_SkillBridge");

// Create connection using musqli_connect function
// Connection Check
if (!$con) {
    die("Connection failed: " . $con->connect_error);
}

else{
   echo "Connected Successfully!";
   $con->close();
}

?>