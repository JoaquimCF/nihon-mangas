<?php
    header("Content-type: application/json");   
    http_response_code(200);
    $usuari = ["nick"=> $stored_user->get_nick()];
    echo json_encode($usuari).PHP_EOL;
?>
 