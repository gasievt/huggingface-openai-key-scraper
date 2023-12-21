<?php
include "./functions.php";
$chars = array_merge(range('a', 'z'), range('A', 'Z'), range('0', '9'));
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