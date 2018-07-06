<?php
include('database/function_data.php');
include('database/data.php');

define('DISTANCE_1KM', 0.0091564348049999);


if (!empty($_POST['lat']) && !empty($_POST['lng'])) {
   
   //echo $_POST['lat'];
    $numer_km = 50;
     $x = (is_numeric($_POST['lat']) ? $_POST['lat'] : 0.1) ;
     $y = (is_numeric($_POST['lng']) ? $_POST['lng'] : 0.2) ;
   
       $xc = $x-DISTANCE_1KM*$numer_km;
      
       $xd = $x+DISTANCE_1KM*$numer_km;
      
       $ya = $y-DISTANCE_1KM*$numer_km;
       
       $yb = $y+DISTANCE_1KM*$numer_km;

     $query = "SELECT `lat`,`lng` FROM tbl_shops WHERE `lat` BETWEEN $xc AND $xd AND `lng` BETWEEN $ya AND $yb  LIMIT 0 , 50  ";
    
    $result = FETCH_ASSOC($query);

    if(count($result) == 0) {
        echo '0';
        die();
    }
    print_r(json_encode($result));

}
?>