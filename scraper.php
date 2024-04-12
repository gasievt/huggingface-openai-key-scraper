<?php
include "./functions.php";
$mode = 'default';
while(sizeof($argv)>0){
    $flag = array_shift($argv);
    switch ($flag){
        case '-mode':{
            if(sizeof($argv)===0){
                echo "ERROR: No value was provided for flag $flag" . PHP_EOL;
                die();
            }
            global $mode;
            $arg = array_shift($argv);
            switch($arg){
                case 'slow':{
                   $mode = 'slow';
                   break;
                }
                default:
                    echo "ERROR: No such mode: $arg" . PHP_EOL;
                    die();
            }
        }
    }
}
$chars = array_merge(range('a', 'z'), range('A', 'Z'), range('0', '9'));
$path = __DIR__;
foreach($chars as $char){
    for($i=0; $i<=1000; $i+=100){
        echo "Scraping: $char char" . ' ' . "Page № $i" . PHP_EOL;
        $command = "php $path/get_keys.php --char=$char --index=$i > /dev/null &";
        exec($command);
        ifSlowModeDelay($mode);
    }
}

do{
    $flag = false;
    if(isScriptsRunning('get_keys.php')){
        pleaseWaitAnimation('Please wait');
    }
    else{
        echo PHP_EOL .'Done!' . PHP_EOL;
        $flag = true;
    }
}while(!$flag);
isFileEmpty('keys.txt');
$uniqueKeys = array_unique(explode(PHP_EOL, file_get_contents('keys.txt')));
cleanupFile('keys.txt');
foreach($uniqueKeys as $key){
    echo "Validating $key" . PHP_EOL;
    $command = "php $path/validate_keys.php --key=$key > /dev/null &";
    exec($command);
    ifSlowModeDelay($mode);
}

do{
    $flag = false;
    if(isScriptsRunning('validate_keys.php')){
        pleaseWaitAnimation("Validating keys");
    }
    else{
        echo PHP_EOL . 'Done!' . PHP_EOL;
        $flag = true;
    }
}while(!$flag);
