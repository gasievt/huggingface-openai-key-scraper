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

function isValidKey($ch){
    if (!curl_errno($ch)) {
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        switch ($httpCode) {
          case 200:
              return true;
          default:
              return false;
        }
      }
}

function cleanupFile($file){
    $fd = fopen($file, 'w');
    fclose($fd);
}
?>