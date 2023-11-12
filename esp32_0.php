<?php
function esp320(){
    $file = './esp32-pin.json';
    file_put_contents($file, json_encode(["value" => 0]));
     
}
?>