<?php



   
    6371 * acos( cos( radians($lat) ) * cos( radians( lat ) ) * 
        cos( radians( lng ) - radians($lng) ) + sin( radians($lat) ) * sin( radians( lat ) ) ) = 5

        (acos(cos(5/ 6371) - sin( radians($lat) ) * sin( radians( $lat ) )/(cos( radians($lat) ) * cos( radians( $lat ) ))) + radians($lng) ) =     radians( lng ) 
}


SELECT (acos(cos(5/ 6371) - sin( radians(10.8307609) ) * sin( radians( 10.8307609 ) )/(cos( radians(10.8307609) ) * cos( radians( 10.8307609 ) ))) + radians(106.6890806) ) AS aaaa

radian(122.23892239515)


 6371 * acos( cos( radians($lat) ) * cos( radians( lat ) ) * cos( radians( lng ) - radians($lng) ) + sin( radians($lat) ) * sin( radians( lat ) ) ) = 5

 
 (radians($lng) +acos((cos(5/6371) - sin( radians($lat) ) * sin( radians( $lat ) ))/(cos( radians($lat) ) * cos( radians( $lat ) ))))*57.29578  = radians( lng )
 
 (radians($lng) +acos((cos(5/6371) - sin( radians($lat) ) * sin( radians( $lat ) ))/(cos( radians($lat) ) * cos( radians( $lat ) ))))*57.29578  = radians( lng )
106.73485181215206
?>