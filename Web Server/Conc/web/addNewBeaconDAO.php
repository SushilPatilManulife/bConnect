<?php
	include('Conn.php');
	include("MySQLDao.php");
	$name=$_REQUEST['name'];
	$major=$_REQUEST['major'];
	$minor=$_REQUEST['minor'];
	$uuid=$_REQUEST['uuid'];
	$username=$_REQUEST['username'];
    $dao = new MySQLDao();
    $u_id=$dao->getUserDetails($username);
	$query = "select * from `beacon_information` where major='$major' AND minor='$minor' AND uuid='$uuid'";
    $result = $conn->query($query);
    if($result->num_rows>=1)
	{
       $finalResponse = array("Status"=>"False","Title"=>"Unsuccess","Message"=>"Beacon already exist.");
        echo json_encode($finalResponse);
	}
	else
	{
        $query2 = "INSERT INTO `beacon_information` (`u_id`,`beacon_name`, `uuid`, `major`, `minor`) VALUES ('$u_id', '$name', '$uuid', '$major', '$minor')";
		$spublic1=$conn->query($query2);
		if($spublic1)
        {
               // $finalResponse = array("Status"=>"True","Title"=>"Success","Message"=>"New beacon added successfully.");
               // echo json_encode($finalResponse);
                echo "<script>";
                echo "alert('New beacon added successfully..');";
                echo "location='/Conc/web/admin_pannel.php?username=".$username."';";
                echo "</script>";  
        }
        else
        {
            //$finalResponse = array("Status"=>"False","Title"=>"Unsuccess","Message"=>"Failed to add new beacon Please Check details.");
           // echo json_encode($finalResponse);
            echo "<script>";
            echo "alert('Failed to add new beacon Please Check details.');";
            echo "location='/Conc/web/admin_pannel.php?username=".$username."';";
            echo "</script>";
        }
	}
?>