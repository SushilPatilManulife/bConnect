<?php
	include('Conn.php');
	
	//$name=$_REQUEST['name'];
	$title=$_REQUEST['title'];
	$description=$_REQUEST['description'];
	$status=$_REQUEST['status'];
	$uuid=$_REQUEST['uuid'];
	$major=$_REQUEST['major'];
	$minor=$_REQUEST['minor'];
    $image=$_REQUEST['image'];

   // $license=$_REQUEST['shop_license'];
    
    
	$sql1 = mysql_query("select * from login where email='$email'");
	if(strlen($mobile)<10||strlen($mobile)>10)
    {
        
        $finalResponse = array("Status"=>"False","Title"=>"Unsuccess","Message"=>"check phone number.");
        echo json_encode($finalResponse);
        
    }
    elseif(mysql_num_rows($sql1)>=1)
	{
       $finalResponse = array("Status"=>"False","Title"=>"Unsuccess","Message"=>"User already exits.");
            echo json_encode($finalResponse);

	}
	
	else
	{
       
        $sql2 = "INSERT INTO `concordia_ibeacon`.`login` (`username`, `password`, `email`, `mobile`, `type`) VALUES ('$username', '$password', '$email', '$mobile', 'user');";
        
		$spublic1=mysql_query($sql2);
        
		if($spublic1)
        {
            //echo ' Sucess';
            
                        $finalResponse = array("Status"=>"True","Title"=>"Success","Message"=>"Registration Successful.");
                echo json_encode($finalResponse);
                echo "<script>";
                echo "alert('Registration Successful.');";
                echo "location='/Conc/web/admin_pannel.php?username=".$username."';";
                echo "</script>";
        }
        else
        {
            $finalResponse = array("Status"=>"False","Title"=>"Unsuccess","Message"=>"Registration Fail Please Check details.");
            echo json_encode($finalResponse);
            echo "<script>";
            echo "alert('Registration Fail Please Check details.');";
            echo "location='/Conc/web/admin_pannel.php?username=".$username."';";
            echo "</script>";
             //header("Location: /Conc/web/admin_pannel.php?username=$username");
        }
	//}
?>
