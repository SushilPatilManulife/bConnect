<?php
	include('Conn.php');
    $username = $_REQUEST['username'];
    $adv_id = $_REQUEST['adv_id'];

//    $n_id = $_REQUEST['n_id'];
//    $category = $_REQUEST['category'];
//    $sub_category = $_REQUEST['sub_category'];
    //$beacon_name=$_REQUEST['beacon_name'];
//	$title=$_REQUEST['title'];
//	$entry_description=$_REQUEST['entry_description'];
//    $exit_description=$_REQUEST['exit_description'];
//	$cat_id=$_REQUEST['category'];
//	$sub_cat_id=$_REQUEST['sub_category'];
//    $date=date("Y-m-d");
//    $filetmp = $_FILES["image"]["tmp_name"];
//	$filename = $_FILES["image"]["name"];
//    $image=$_REQUEST['image'];
//    $new_img="";
//    if($filename=="")
//        $new_img = $image;
//    else 
//        $new_img = $filename;
//    $filepath = "images/".$new_img;
//    move_uploaded_file($filetmp,$filepath);
      $sql2 = "update `advertisement_details` SET `status`=0 where adv_id='$adv_id'";
		$spublic1=$conn->query($sql2);
		if($spublic1)
        {
            //$finalResponse = array("Status"=>"True","Title"=>"Success","Message"=>"Notification updated Successful.");
            //echo json_encode($finalResponse);
            echo "<script>";
            echo "alert('Advertisement updated Successfully.');";
            echo "location='/Conc/web/user_pannel.php?username=".$username."';";
            echo "</script>"; 
        }
        else
        {
            //$finalResponse = array("Status"=>"False","Title"=>"Unsuccess","Message"=>"Notification update Fail Please Check details.");
            //echo json_encode($finalResponse);
            echo "<script>";
            echo "alert('Advertisement update Fail Please Check details..');";
            echo "location='/Conc/web/user_pannel.php?username=".$username."';";
            echo "</script>";
        }
?>