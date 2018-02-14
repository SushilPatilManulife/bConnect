<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "id2353742_concordia_ibeacon";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error){
die("Connection failed: " . $conn->connect_error);
}
?>