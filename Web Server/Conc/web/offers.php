<?php
    include('Conn.php');
    $query  = "SELECT * FROM `notification_information`";
    $result = $conn->query($query);
    $response = array();
    while( $row = $result->fetch_assoc()){
        $bID = $row["b_id"];
        $query1 = "SELECT * FROM `beacon_information` WHERE `b_id` = $bID";
        $result1 = $conn->query($query1);
        $response1 = array();
         while( $row1 = $result1->fetch_assoc()){
            array_push($response1,$row1);
            //$row["medicine"] = $response_carImage;
        }
        $row["Beacon_info"] = $response1;
        
        $cID = $row["category"];
        $subID=$row["sub_category"];
        $query2 = "SELECT * FROM category where cat_id=$cID";
        $result2 = $conn->query($query2);
        $response2 = array();
         while( $row2 = $result2->fetch_assoc()){
            array_push($response2,$row2);
            //$row["medicine"] = $response_carImage;
        }
        $row["Category_info"] = $response2;
        
        array_push($response,$row);
    }
    if( $result && count($response)>=1) {
        $finalResponse = array("status"=>"True","message"=>" Sucessfull ", "result" => $response);
        echo json_encode($finalResponse);
    }
    else {
        $finalResponse = array("status"=>"False","message"=>"failed to execute ","result" => $response);
        echo json_encode($finalResponse);
    }		
?>
