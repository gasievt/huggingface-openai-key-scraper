<?php

function isScriptsRunning($scriptName){
    $output = shell_exec('ps -C php -f');
    if (strpos($output, $scriptName) !== false){
        sleep(1);
        return true;
    }
    else{
        return false;
    }
}

function isValidKey($output){
    if(array_key_exists('data', json_decode($output, true))){
        return true;
    }
    else{
        return false;
    }
}

function cleanupFile($file){
    $fd = fopen($file, 'w');
    fclose($fd);
}
?>