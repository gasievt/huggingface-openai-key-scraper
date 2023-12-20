<?php
    include "./functions.php";
    set_time_limit(60);
    $key = explode('--key=', $argv[1])[1];
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api.openai.com/v1/chat/completions");
    curl_setopt($ch, CURLOPT_POST, 1);
    $headers = [
        "Content-Type: application/json",
        "Authorization: Bearer $key"
    ];
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    foreach($models as $model){
        curl_setopt($ch, CURLOPT_POSTFIELDS,
            json_encode(['model'=>$model,
             'messages'=>[['role'=>'user', 'content'=>'Hi']],
             'temperature'=>0.7]));
        curl_exec($ch);
        if(isValidKey($ch)){
            $fd = fopen("$model.txt", 'a+');
            fwrite($fd, $key . PHP_EOL);
            fclose($fd);
        }   
    }
?>