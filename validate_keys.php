<?php
    include "./functions.php";
    $key = explode('--key=', $argv[1])[1];
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api.openai.com/v1/models");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $headers = [
        "Content-Type: application/json",
        "Authorization: Bearer $key"
        
    ];
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $output = curl_exec($ch);


    if(isValidKey($output)){
        $fd = fopen('uniqueKeys.txt', 'a+');
        fwrite($fd, $key . PHP_EOL);
        fclose($fd);
    }
?>