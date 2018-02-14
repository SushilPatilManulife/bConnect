<?php
	include('Conn.php');
	include('MySQLDao.php');
    $username = $_REQUEST['username'];
   // $category = $_REQUEST['category'];
	$beacon_name=$_REQUEST['beacon_name'];
	$title=$_REQUEST['title'];
	$entry_description=$_REQUEST['entry_description'];
    $exit_description=$_REQUEST['exit_description'];
//	$status=$_REQUEST['status'];
//    if($status!="1")
//        $status="0";
	$cat_id=$_REQUEST['cat_id'];
    $url=$_REQUEST['url'];
	$sub_cat_id=$_REQUEST['sub_cat_id'];
    $date=date("Y-m-d");
    $filetmp = $_FILES["image"]["tmp_name"];
	$filename = $_FILES["image"]["name"];
    $filepath = "images/".$filename;
    move_uploaded_file($filetmp,$filepath);

    $dao = new MySQLDao();
    $b_id = $dao->getUserBID($beacon_name);
	
    //$imageData = mysql_real_escape_string(file_get_contents($_FILES["image"]["tmp_name"]));
       
        $sql2 = "INSERT INTO `notification_information` (`b_id`, `category`, `sub_category`, `title`, `entry_description`,`exit_description`, `created_at`,`information`,`image`) VALUES ('$b_id','$cat_id','$sub_cat_id','$title','$entry_description','$exit_description','$date','$url','$filename')";
        
		$spublic1=$conn->query($sql2);
        
		if($spublic1)
        {
            //echo ' Sucess';
            
            //$finalResponse = array("Status"=>"True","Title"=>"Success","Message"=>"Notification data upload Successful.");
           // echo json_encode($finalResponse);
            echo "<script>";
            echo "alert('Notification data upload Successful.');";
            echo "location='/Conc/web/user_pannel.php?username=".$username."';";
            echo "</script>";
           //  header("Location: /Conc/web/user_pannel.php?username=$username");
        }
        else
        {
            //$finalResponse = array("Status"=>"False","Title"=>"Unsuccess","Message"=>"Notification upload Fail Please Check details.");
            //echo json_encode($finalResponse);
            echo "<script>";
            echo "alert('Notification upload Fail Please Check details.');";
            echo "location='/Conc/web/user_pannel.php?username=".$username."';";
            echo "</script>";
            // header("Location: /Conc/web/user_pannel.php?username=$username");
            
        }
     
?>
