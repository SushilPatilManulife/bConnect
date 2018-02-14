<?php
include('Conn.php');
$username = $_REQUEST['username'];
$password =  $_REQUEST['password'];
$secure_password = md5($password);
$query  = "SELECT * FROM `login` WHERE `username` = '$username' AND `password` = '$secure_password' ";
$result = $conn->query($query);
$response = array();
while( $row = $result->fetch_assoc()){
array_push($response,$row);
}
if( $result && count($response)>=1) {
//$finalResponse = array("status"=>"True","message"=>"Login Sucessfull ", "result" => $response);
//echo json_encode($finalResponse);
if($username!='admin'){
echo "<script>";
echo "location='/Conc/web/user_pannel.php?username=".$username."';";
echo "</script>";    
}else{
echo "<script>"; 
echo "location='/Conc/web/admin_pannel.php?username=".$username."';";
echo "</script>"; 
}
}
else{
echo "<script>";
echo "alert('Incorrect username or Password! Please try again');";
echo "location='/Conc/web/index.html';";
echo "</script>"; 
}		
?>