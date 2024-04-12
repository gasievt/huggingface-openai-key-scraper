<?php
$models = ['gpt-3.5-turbo', 'gpt-4'];
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

function pleaseWaitAnimation($message){
    $animation = ['|','/','-','\\','\\'];
    foreach($animation as $char){
        echo $message . "[".$char."]"."\r";
        usleep(20000);
    }
}

function isFileEmpty($file){
    if(filesize($file)===0){
        throw new Exception("File is empty");
    }
}

function ifSlowModeDelay($mode){
    if($mode==='slow'){
        return usleep(50000);
    }
}
