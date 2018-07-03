<?php
include('database/function_data.php');
include('database/data.php');


if(!empty($_POST['lat']) && !empty($_POST['lng'])){
    //Send request and receive json data by latitude and longitude
   // $url = 'http://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($_POST['lat']).','.trim($_POST['lng']).'&sensor=false';
    $lat = $_POST['lat'];
    $lng = $_POST['lng'];
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

    $query =  "SELECT id,`lat`,`lng`, ( 6371 * acos( cos( radians($lat) ) * cos( radians( lat ) ) * cos( radians( lng ) - radians($lng) ) + sin( radians($lat) ) * sin( radians( lat ) ) ) ) AS distance FROM markers HAVING distance < 25 ORDER BY distance LIMIT 0 , 20";
    $result = FETCH_ASSOC($query);
    print_r(json_encode($result));

}
?>