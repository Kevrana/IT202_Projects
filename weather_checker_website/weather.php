<?php

// get the zip from the weather.html
$zip = $_GET["zip"];

// gives the php functions a bit of a delay
sleep (3);

// insert the $zip into the url so it can get the json string for that zip
$url = "http://api.openweathermap.org/data/2.5/weather?zip=$zip,us&units=metric&appid=01daea6f23861bd92cc67384646b792b"; 

$fp = fopen ( $url , "r" ); 
$contents = "";
while ( $more = fread ( $fp, 1000  ) ) {      $contents .=  $more ;   }
echo $contents ; 


?>