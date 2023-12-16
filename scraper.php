<?php
include "./functions.php";
$chars = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
'1','2','3','4','5','6','7','8','9','0', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
$path = __DIR__;

cleanupFile('keys.txt');
foreach($chars as $char){
    for($i=0; $i<=1000; $i+=100){
        echo "Scraping: $char char" . ' ' . "Page № $i" . PHP_EOL;
        $command = "php $path/get_keys.php --char=$char --index=$i > /dev/null &";
        exec($command);
    }
}

do{
    $flag = false;
    if(isScriptsRunning('get_keys.php')){
        echo 'Please wait...' . PHP_EOL;
    }
    else{
        echo 'Done!' . PHP_EOL;
        $flag = true;
    }
}while(!$flag);

$uniqueKeys = array_unique(explode(PHP_EOL, file_get_contents('keys.txt')));
foreach($uniqueKeys as $key){
    echo "Validating $key" . PHP_EOL;
    $command = "php $path/validate_keys.php --key=$key > /dev/null &";
    exec($command);
}

do{
    $flag = false;
    if(isScriptsRunning('validate_keys.php')){
        echo 'Validating keys...' . PHP_EOL;
    }
    else{
        echo 'Done!' . PHP_EOL;
        $flag = true;
    }
}while(!$flag);

?>