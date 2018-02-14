<?php
	include('Conn.php');
	$mobile=$_REQUEST['mobile'];
	$email=$_REQUEST['email'];
	$username=$_REQUEST['username'];
	$password=$_REQUEST['password'];
    $secure_password = md5($password);
    $query = "select * from login where email='$email' AND username='$username'";
    $result = $conn->query($query);
	if(strlen($mobile)<10||strlen($mobile)>10)
    {
        $finalResponse = array("Status"=>"False","Title"=>"Unsuccess","Message"=>"check phone number.");
        echo json_encode($finalResponse);
    }
    elseif($result->num_rows>=1)
	{
       $finalResponse = array("Status"=>"False","Title"=>"Unsuccess","Message"=>"User already exits.");
            echo json_encode($finalResponse);
    }
	else
	{
            $query2 = "INSERT INTO `login` (`username`, `password`, `email`, `mobile`, `type`) VALUES ('$username', '$secure_password', '$email', '$mobile', 'user');";
		$spublic1=$conn->query($query2);
		if($spublic1)
        {
           // $finalResponse = array("Status"=>"True","Title"=>"Success","Message"=>"Registration Successful.");
           // echo json_encode($finalResponse);
            echo "<script>";
            echo "alert('Registration Successful.');";
            echo "location='/Conc/web/admin_pannel.php?username=".$username."';";
            echo "</script>";
        }
        else
        {
            //$finalResponse = array("Status"=>"False","Title"=>"Unsuccess","Message"=>"Registration Fail Please Check details.");
           // echo json_encode($finalResponse);
            echo "<script>";
            echo "alert('Registration Fail Please Check details.');";
            echo "location='/Conc/web/admin_pannel.php?username=".$username."';";
            echo "</script>";
        }
	}
?>