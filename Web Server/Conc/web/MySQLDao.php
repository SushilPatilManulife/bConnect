<?php
include("Conn.php");
class MySQLDao {
public function getUserDetails($username)
{
global $conn;
$query  = "SELECT * FROM `login` WHERE `username` = '$username' ";
$result = $conn->query($query);
while( $row = $result->fetch_assoc()){
$response=$row['u_id'];
}
return $response;
}
public function  getUserCount()
{ 
global $conn;
$query  = "SELECT * FROM `login` where type='user' ";
$result = $conn->query($query);
$response=$result->num_rows;
return $response;
} 
public function getBeaconDetails()
{ 
global $conn;
$query  = "SELECT * FROM `beacon_information`  ";
$result = $conn->query($query);
$response=$result->num_rows;
return $response;
}
public function getBeaconFromID($b_id)
{
global $conn;
$query  = "SELECT * FROM `beacon_information` WHERE `b_id` = $b_id ";
$result = $conn->query($query);
while( $row = $result->fetch_assoc()){
$response=$row['beacon_name'];
}
return $response;
} 
public function getUsernameFromBeacon($beacon)
{
global $conn;
$query  = "SELECT * FROM `login` WHERE u_id=(select u_id from `beacon_information` where beacon_name='$beacon')";
$result = $conn->query($query);
while( $row = $result->fetch_assoc()){
$response=$row['username'];
}
return $response;
}
public function getUserFromID($u_id)
{
global $conn;   
$query  = "SELECT * FROM `login` WHERE `u_id` = $u_id ";
$result = $conn->query($query);
while( $row = $result->fetch_assoc()){
$response=$row['username'];
}
return $response;
}   
public function getUserBID($beacon_name)
{
global $conn;
$query  = "SELECT * FROM `beacon_information` WHERE `beacon_name` = '$beacon_name' ";
$result = $conn->query($query);
while( $row = $result->fetch_assoc()){
$response=$row['b_id'];
}
return $response;
}   
public function getCategory($cat)
{
global $conn;
$query  = "SELECT * FROM `category` WHERE `cat_id` = '$cat' ";
$result = $conn->query($query);
while( $row = $result->fetch_assoc()){
$response=$row['category_name'];
}
return $response;
}
public function getSubCategory($subCat)
{
global $conn;
$query  = "SELECT * FROM `sub_category` WHERE `subCat_id` = '$subCat' ";
$result = $conn->query($query);
while( $row = $result->fetch_assoc()){
$response=$row['sub_category_name'];
}
return $response;
}

}
?>