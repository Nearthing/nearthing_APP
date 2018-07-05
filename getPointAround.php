<?php
include('database/function_data.php');
include('database/data.php');
define('DISTANCE_1KM', 0.0091564348049999);


if (!empty($_POST['lat']) && !empty($_POST['lng'])) {
   
   //echo $_POST['lat'];
    $numer_km = 2;
     $x = (is_numeric($_POST['lat']) ? $_POST['lat'] : 0.1) ;
     $y = (is_numeric($_POST['lng']) ? $_POST['lng'] : 0.2) ;
   
       $xc = $x-DISTANCE_1KM*$numer_km;
      
       $xd = $x+DISTANCE_1KM*$numer_km;
      
       $ya = $y-DISTANCE_1KM*$numer_km;
       
       $yb = $y+DISTANCE_1KM*$numer_km;

     $query = "SELECT `id`,`lat`,`lng` FROM markers WHERE `lat` BETWEEN $xc AND $xd AND `lng` BETWEEN $ya AND $yb  LIMIT 0 , 50";
    
    $result = FETCH_ASSOC($query);

    print_r(json_encode($result));

}
?>