<?php
	include('Conn.php');
	$mobile=$_REQUEST['mobile'];
	$user_name=$_REQUEST['user_name'];
    $n_id = $_REQUEST['n_id'];
  
        $query2 = "INSERT INTO `advertisement_details` (`n_id`, `user_name`, `mobile`,`status`) VALUES ('$n_id', '$user_name', '$mobile', '1')";
                 
		$spublic1=$conn->query($query2);
		if($spublic1)
        {
            $finalResponse = array("Status"=>"True","Title"=>"Success","Message"=>"Registration Successful.");
            echo json_encode($finalResponse);
          
        }
        else
        {
            $finalResponse = array("Status"=>"False","Title"=>"Unsuccess","Message"=>"Registration Fail Please Check details.");
            echo json_encode($finalResponse);
        }
	
?>