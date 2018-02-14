<!DOCTYPE html>
<html>
<head>
</head>
<body>
<?php
include("Conn.php");
$q = $_GET['q'];
$query  = "SELECT * FROM `beacon_information` WHERE `beacon_name` = '".$q."' ";
$result = $conn->query($query);
while( $row = $result->fetch_assoc()){
            echo "<div id=txtHint>";        
            echo "<div class='form-group' >";
            echo "<label for='uuid' class='control-label col-lg-3'>UUID</label>";
            echo "<div class='col-lg-6'>";
            echo "<input class='form-control' id='uuid' name='uuid' value=". $row['uuid']." type='text' disabled>";
            echo "</div>";
            echo "</div>";
            echo "<div class='form-group' >";
            echo "<label for='major' class='control-label col-lg-3'>Major</label>";
            echo "<div class='col-lg-6'>";
            echo "<input class='form-control' id='major' name='major' value=". $row['major']." type='text' disabled>";
            echo "</div>";
            echo "</div>";
            echo "<div class='form-group' >";
            echo "<label for='minor' class='control-label col-lg-3'>Minor</label>";
            echo "<div class='col-lg-6'>";
            echo "<input class='form-control' id='minor' name='minor' value=". $row['minor']." type='text' disabled>";
            echo "</div>";
            echo "</div>";
            echo "</div>";        
    }
?>
</body>
</html>