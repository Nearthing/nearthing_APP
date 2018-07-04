<?php
include('database/function_data.php');
include('database/data.php');


if(!empty($_POST['lat']) && !empty($_POST['lng'])){
    //Send request and receive json data by latitude and longitude
   // $url = 'http://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($_POST['lat']).','.trim($_POST['lng']).'&sensor=false';
    
    // // $json = @file_get_contents($url);
    // // $data = json_decode($json);
    // // $status = $data->status;
    // // if($status=="OK"){
    //     //Get address from json data
    // //     $location = $data->results[0]->formatted_address;
    // // }else{
    // //     $location =  '';
    // // }
    // //Print address 
    // //echo $location;

    $lat = $_POST['lat'];
    $lng = $_POST['lng'];
    
    
    $x = $_POST['lat'];
    $y = $_POST['lng'];

     $ya = (deg2rad ($y) -acos((cos(6/6371) - sin( deg2rad ($x) ) * sin( deg2rad ( $x ) ))/(cos( deg2rad ($x) ) * cos( deg2rad ( $x ) ))))*57.29578;
     '<br>';
     $yb = (deg2rad ($y) + acos((cos(6/6371) - sin( deg2rad ($x) ) * sin( deg2rad ( $x ) ))/(cos( deg2rad ($x) ) * cos( deg2rad ( $x ) ))))*57.29578;
     '<br>';

     "<br>";
     $xc = $x - sqrt(-($ya - $y)*($yb - $y));
     "<br>";
      $xd = sqrt(-($ya - $y)*($yb - $y))+$x ;

   echo  $query = "SELECT `id`,`lat`,`lng` FROM markers WHERE `lat` BETWEEN $xc AND $xd AND `lng` BETWEEN $ya AND $yb  LIMIT 0 , 20";
die();
    // echo $query =  "SELECT id,`lat`,`lng`, 
    // ( 6371 * acos( cos( radians($lat) ) * cos( radians( lat ) ) * cos( radians( lng ) - radians($lng) ) + sin( radians($lat) ) * sin( radians( lat ) ) ) )
    //   AS distance FROM markers HAVING distance < 5 ORDER BY distance LIMIT 0 , 20";
    
    $result = FETCH_ASSOC($query);

    print_r(json_encode($result));

}
?>