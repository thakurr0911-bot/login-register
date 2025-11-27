<?php
$servername = "localhost";
$username = "root";
$password = "";
$db_name = "form";

$link = mysqli_connect($servername, $username, $password, $db_name);
if ($link == false) {
    die("ERROR:Database connection" . mysqli_connect_error());
}
// else{
//     echo "Database connection successful";
// 
?>






