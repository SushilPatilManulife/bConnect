   
<div class="nav notify-row" id="top_menu">
    
    <?php
    
    function trim_text($text, $count){ 
    $text = str_replace("  ", " ", $text); 
    $string = explode(" ", $text); 
        $trimed="";
    for ( $wordCounter = 0; $wordCounter <= $count; $wordCounter++){ 
    $trimed .= $string[$wordCounter]; 
    if ( $wordCounter < $count ){ $trimed .= " "; } 
    else { $trimed .= "..."; } 
    } 
    $trimed = trim($trimed); 
    return $trimed; 
    } 
    //include 'Conn.php';
   
  //  $username = $_REQUEST['username']; 
    
     $query1  = "select * from login INNER JOIN beacon_information ON login.u_id=beacon_information.u_id INNER JOIN notification_information ON notification_information.b_id=beacon_information.b_id INNER JOIN sub_category ON notification_information.sub_category=sub_category.subCat_id INNER JOIN category ON notification_information.category=category.cat_id INNER JOIN advertisement_details ON notification_information.n_id=advertisement_details.n_id where login.username='".$username."' and advertisement_details.status=1;";
         
     $result1 = $conn->query($query1);
    
    $cnt=mysqli_num_rows($result1);
?>

    
    
    <!--  notification start -->
    <ul class="nav top-menu">
        <!-- settings start -->
        <li class="dropdown">
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                <i class="fa fa-tasks"></i>
                <span class="badge bg-success"><?=$cnt?></span>
            </a>
            <ul class="dropdown-menu extended tasks-bar">
                <li>
                    <p class="">You have <?=$cnt?> pending tasks</p>
                </li>
            <?php
                 while( $row1 = $result1->fetch_assoc()){
                        $cnt=$cnt+1;

                        $category = $row1['category'];
                        $sub_category = $row1['sub_category'];
                        $user_name = $row1['user_name']; 
                        $title = $row1['title'];
              ?>
                 <li>
                    <a href="advertisement_Notification.php?username=<?=$username?>">
                        <div class="task-info clearfix">
                            <div class="desc pull-left">
                                <h5> <?= trim_text($title, 2);?></h5>
                                <p>Request by : <?=$user_name?></p>
                            </div>
                                    <span class="notification-pie-chart pull-right" data-percent="65">
                            <span class="percent"></span>
                            </span>
                        </div>
                    </a>
                </li>
                <?php
                 }
                ?>
                <li class="external">
                    <a href="#">See All Tasks</a>
                </li>
            </ul>
        </li>
        <!-- settings end -->
        <!-- inbox dropdown start-->
        <li id="header_inbox_bar" class="dropdown">
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                <i class="fa fa-envelope-o"></i>
                <!--<span class="badge bg-important">0</span>-->
            </a>
            <ul class="dropdown-menu extended inbox">
                <li>
                    <p class="red">You have 0 Mails</p>
                </li>
                
                <li>
                    <a href="#">See all messages</a>
                </li>
            </ul>
        </li>
        <!-- inbox dropdown end -->
        <!-- notification dropdown start-->
        <li id="header_notification_bar" class="dropdown">
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">

                <i class="fa fa-bell-o"></i>
                <!--<span class="badge bg-warning">0</span>-->
            </a>
            <ul class="dropdown-menu extended notification">
                <li>
                    <p>Notifications</p>
                </li>
                
            </ul>
        </li>
        <!-- notification dropdown end -->
    </ul>
    <!--  notification end -->
</div>